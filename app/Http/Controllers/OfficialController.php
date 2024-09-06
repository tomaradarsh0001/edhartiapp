<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ApplicationMovement;
use App\Services\UserRegistrationService;
use App\Models\PropertyMaster;
use App\Models\User;
use App\Models\Item;
use App\Models\ApplicationStatus;
use App\Models\NewlyAddedProperty;
use App\Models\UserRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NewlyAddedPropertyExport; // Create this export class
use App\Exports\UserRegistrationExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use App\Helpers\GeneralFunctions;
use App\Services\SettingsService;
use App\Services\CommunicationService;
use App\Mail\CommonMail;
use Illuminate\Support\Facades\Mail;

class OfficialController extends Controller
{
    protected $userRegistrationService;
    protected $communicationService;
    protected $settingsService;

    public function __construct(UserRegistrationService $userRegistrationService, CommunicationService $communicationService, SettingsService $settingsService)
    {
        $this->userRegistrationService = $userRegistrationService;
        $this->communicationService = $communicationService;
        $this->settingsService = $settingsService;
    }

    public function index()
    {
        $user = Auth::user();
        $filterPermissionArr = [];
        $permissionMap = [
            'view.registration.new' => 'RS_NEW',
            'view.registration.approved' => 'RS_APP',
            'view.registration.rejected' => 'RS_REJ',
            'view.registration.under_review' => 'RS_UREW',
            'view.registration.reviewed' => 'RS_REW',
            'view.registration.pending' => 'RS_PEN',
        ];

        $allPermissions = $user->getAllPermissions();
        foreach ($allPermissions as $permission) {
            if (isset($permissionMap[$permission->name])) {
                $filterPermissionArr[] = $permissionMap[$permission->name];
            }
        }

        if (!empty($filterPermissionArr)) {
            $items = Item::where('group_id', 17000)
                ->whereIn('item_code', $filterPermissionArr)
                ->get();
        }
        return view('officials.register-users.indexDatatable', compact('items'));
    }

    //Add by lalit on 31/07/2024 to show register user listing
    public function getUserRegistrations($user, $sections)
    {
        // Base query builder
        $query = UserRegistration::with('oldColony')
            ->leftJoin('application_movements', function ($join) {
                $join->on('user_registrations.applicant_number', '=', 'application_movements.application_no')
                    ->whereIn('application_movements.id', function ($subQuery) {
                        $subQuery->select(DB::raw('MAX(id)'))
                            ->from('application_movements')
                            ->groupBy('application_no');
                    });
            })
            ->leftJoin('users as assigned_by_user', 'application_movements.assigned_by', '=', 'assigned_by_user.id')
            ->leftJoin('users as assigned_to_user', 'application_movements.assigned_to', '=', 'assigned_to_user.id')
            ->leftJoin('items', 'user_registrations.status', '=', 'items.id')
            ->select(
                'user_registrations.*',
                'items.item_name',
                'items.item_code',
                'application_movements.assigned_by',
                'assigned_by_user.name as assigned_by_name',
                'application_movements.assigned_to',
                'assigned_to_user.name as assigned_to_name'
            )
            ->whereIn('section_id', $sections)
            ->orderBy('user_registrations.created_at', 'asc');

        // Adjust query based on user role
        if ($user->roles[0]['name'] == 'deputy-lndo') {
            $query->where('user_registrations.status', getStatusName('RS_UREW'));
        }

        // Paginate results
        $dataWithPagination = $query->paginate(20);

        return $dataWithPagination;
    }

    public function getRegisteredUsers(Request $request)
    {
        // Get the logged-in user
        $user = Auth::user();
        $sections = $user->sections->pluck('id');
        // Define the query outside of the AJAX block
        $query = UserRegistration::query()
            ->with('oldColony')
            ->leftJoin('application_movements', function ($join) {
                $join->on('user_registrations.applicant_number', '=', 'application_movements.application_no')
                    ->whereIn('application_movements.id', function ($subQuery) {
                        $subQuery->select(DB::raw('MAX(id)'))
                            ->from('application_movements')
                            ->groupBy('application_no');
                    });
            })
            ->leftJoin('users as assigned_by_user', 'application_movements.assigned_by', '=', 'assigned_by_user.id')
            ->leftJoin('users as assigned_to_user', 'application_movements.assigned_to', '=', 'assigned_to_user.id')
            // ->leftJoin('users', 'user_registrations.user_id', '=', 'users.id')
            ->leftJoin('items', 'user_registrations.status', '=', 'items.id')
            ->leftJoin('old_colonies', 'user_registrations.locality', '=', 'old_colonies.id')
            ->select(
                'user_registrations.*',
                'items.item_name',
                'items.item_code',
                'application_movements.assigned_by',
                'assigned_by_user.name as assigned_by_name',
                'application_movements.assigned_to',
                'assigned_to_user.name as assigned_to_name',
                'old_colonies.name as old_colony_name',
                'user_registrations.remarks',
                DB::raw("CONCAT_WS('/', block, plot, old_colonies.name) as property_details"), // Add this line
                'user_registrations.created_at',
            )
            ->whereIn('section_id', $sections);

        // Apply status filter if provided
        if ($request->status) {
            $query->where('user_registrations.status', $request->status);
        }

        // Apply status condition based on user role
        $query->when($request->status || $user->roles[0]['name'] == 'deputy-lndo', function ($q) use ($request, $user) {
            if ($user->roles[0]['name'] == 'deputy-lndo') {
                $q->where('user_registrations.status', $request->status ?? getStatusName('RS_UREW'));
            } else {
                $q->where('user_registrations.status', $request->status);
            }
        });

        $columns = ['id', 'applicant_number', 'name', 'property_details', 'user_type', 'purpose_of_registation', 'document', 'remarks', 'status', 'created_at'];

        $totalData = $query->count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        if($request->input('order.0.column')){
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');
        } else {
            $order = $columns['9'];
            $dir = 'desc';
        }
        
        if (!empty($request->input('search.value'))) {
            $search = $request->input('search.value');
            $query->where(function ($q) use ($search) {
                $q->where('user_registrations.applicant_number', 'LIKE', "%{$search}%")
                    ->orWhere('user_registrations.name', 'LIKE', "%{$search}%")
                    ->orWhere(function ($q) use ($search) {
                        $q->where('user_registrations.block', 'LIKE', "%{$search}%")
                            ->orWhere('user_registrations.plot', 'LIKE', "%{$search}%")
                            ->orWhere('old_colonies.name', 'LIKE', "%{$search}%");
                    })
                    ->orWhere('user_registrations.remarks', 'LIKE', "%{$search}%");
            });

            $totalFiltered = $query->count();
        }

        $getRegistrationDetails = $query->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        $data = [];
        foreach ($getRegistrationDetails as $getRegistrationDetail) {
            $nestedData = [];
            $nestedData['id'] = $getRegistrationDetail->id;
            $nestedData['applicant_number'] = $getRegistrationDetail->applicant_number;
            $nestedData['name'] = $getRegistrationDetail->name;
            $nestedData['property_details'] = ucfirst($getRegistrationDetail->block) . '/' . ucfirst($getRegistrationDetail->plot) . '/' . ucfirst($getRegistrationDetail->old_colony_name);
            $nestedData['user_type'] = $getRegistrationDetail->user_type;
            $nestedData['purpose_of_registation'] = $getRegistrationDetail->purpose_of_registation === 'existing_property'
                ? 'Existing Property'
                : 'Allotment';
            $nestedData['documents'] = [
                'sale_deed_doc' => $getRegistrationDetail->sale_deed_doc,
                'builder_buyer_agreement_doc' => $getRegistrationDetail->builder_buyer_agreement_doc,
                'lease_deed_doc' => $getRegistrationDetail->lease_deed_doc,
                'substitution_mutation_letter_doc' => $getRegistrationDetail->substitution_mutation_letter_doc,
                'owner_lessee_doc' => $getRegistrationDetail->owner_lessee_doc,
                'other_doc' => $getRegistrationDetail->other_doc,
                'authorised_signatory_doc' => $getRegistrationDetail->authorised_signatory_doc,
                'chain_of_ownership_doc' => $getRegistrationDetail->chain_of_ownership_doc,
            ];
            $nestedData['remark'] = [
                'remark' => !empty($getRegistrationDetail->remarks) ? strip_tags($getRegistrationDetail->remarks) : 'NA',
                'assigned_by_name' => !empty($getRegistrationDetail->assigned_by_name) ? $getRegistrationDetail->assigned_by_name : 'NA',
            ];
            $statusClasses = [
                'RS_REJ' => 'text-danger bg-light-danger',
                'RS_NEW' => 'text-primary bg-light-primary',
                'RS_UREW' => 'text-warning bg-light-warning',
                'RS_REW' => 'text-white bg-secondary',
                'RS_PEN' => 'text-info bg-light-info',
                'RS_APP' => 'text-success bg-light-success',
            ];
            $class = $statusClasses[$getRegistrationDetail->item_code] ?? 'text-secondary bg-light';
            $nestedData['status'] = '<div class="badge rounded-pill ' . $class . ' p-2 text-uppercase px-3">' . ucwords($getRegistrationDetail->item_name) . '</div>';
            $nestedData['created_at'] = $getRegistrationDetail->created_at->format('d/m/Y H:i:s');
            $nestedData['action'] = '<a href="' . url('register/user/' . $getRegistrationDetail->id . '/view') . '">
                <button type="button" class="btn btn-success px-5">View</button>
            </a>';
            $data[] = $nestedData;
        }

        $json_data = [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
        ];

        return response()->json($json_data);
    }

    //Add by lalit on 31/07/2024 to update register user status
    public function updateStatus($id, Request $request)
    {
        if (!empty($id)) {
            // DB::transaction(function () use ($id, $request) {
            $updateStatus = UserRegistration::where('id', $id)->update([
                'status' => getStatusName('RS_REJ'),
                'remarks' => $request->remarks
            ]);

            if ($updateStatus) {
                $registerUser = UserRegistration::where('id', $id)->first();

                $applicationMovement = ApplicationMovement::create([
                    'assigned_by' => Auth::user()->id,
                    'service_type' => getServiceType('RS_REG'),
                    'model_id' => $id,
                    'status' => getStatusName('RS_REJ'),
                    'application_no' => $registerUser->applicant_number,
                    'remarks' => $request->remarks
                ]);

                if ($applicationMovement) {
                    if ($registerUser) {
                        ApplicationStatus::create([
                            'service_type' => getServiceType('RS_REG'),
                            'model_id' => $id,
                            'reg_app_no' => $registerUser->applicant_number,
                            'is_mis_checked' => $request->is_mis_checked ? true : false,
                            'is_scan_file_checked' => $request->is_scan_file_checked ? true : false,
                            'is_uploaded_doc_checked' => $request->is_uploaded_doc_checked ? true : false,
                            'created_by' => Auth::user()->id,
                        ]);

                        $data = [
                            'name' => $registerUser->name,
                            'email' => $registerUser->email,
                            'regNo' => $registerUser->applicant_number,
                            'remark' => $registerUser->remarks
                        ];
                        $action = 'REG_REJ';
                        $this->settingsService->applyMailSettings($action);
                        Mail::to($registerUser->email)->send(new CommonMail($data, $action));
                        $this->communicationService->sendSmsMessage($data, $registerUser->mobile, $action);
                        $this->communicationService->sendWhatsAppMessage($data, $registerUser->mobile, $action);
                    }

                    return redirect()->back()->with('success', 'User registration rejected successfully.');
                }
            } else {
                return redirect()->back()->with('failure', 'User registration does not rejected.');
            }
            // });
        }
    }


    //Add by lalit on 31/07/2024 to get register user details for view page
    public function details($id)
    {
        if (!empty($id)) {

            // Retrieve the user's roles
            $roles = Auth::user()->roles[0]->name;
            $data = [];
            $regUserDetails = UserRegistration::find($id);
            if ($regUserDetails) {
                //Fetch Suggested Property Id from Property Master
                $property = PropertyMaster::where('new_colony_name', $regUserDetails->locality)->where('block_no', $regUserDetails->block)->where('plot_or_property_no', $regUserDetails->plot)->first();
                if (!empty($property['id'])) {
                    $data['propertyMasterId'] = $property['id'];
                    $data['suggestedPropertyId'] = $property['old_propert_id'];
                    $data['oldPropertyId'] = $property['old_propert_id'];
                } else {
                    $data['propertyMasterId'] = '';
                    $data['suggestedPropertyId'] = '';
                    $data['oldPropertyId'] = '';
                }
                $data['details'] = $regUserDetails;
                $data['applicationMovementId'] = $id;
                $checkList = ApplicationStatus::where('service_type', getServiceType('RS_REG'))->where('model_id', $id)->first();
                return view('officials.register-users.details', compact('data', 'roles', 'checkList'));
            }
        }
    }

    //Add by lalit on 31/07/2024 to approve user registeration
    public function approvedUserRegistration(Request $request)
    {
        if (!empty($request->registrationId) && !empty($request->suggestedPropertyId) && !empty($request->oldPropertyId) && !empty($request->emailId)) {
            //Check user email is alredy exist in user table
            $emailExists = User::where('email', $request->emailId)->exists();
            if ($emailExists) {
                // Email exists in the users table
                return redirect()->route('regiserUserListings')->with('failure', 'Email is already registered with us.');
            }

            $getUserRegistrationDetails = UserRegistration::find($request->registrationId);
            if (!empty($getUserRegistrationDetails->id)) {
                if ($getUserRegistrationDetails->status == getStatusName('RS_APP')) {
                    return redirect()->route('regiserUserListings')->with('success', 'User has already approved.');
                } else {
                    $result = $this->userRegistrationService->approveRegistration($request);
                    if ($result) {
                        return redirect()->route('regiserUserListings')->with('success', 'User registration approved successfully.');
                    } else {
                        return redirect()->route('regiserUserListings')->with('failure', 'Failed to approve user registration.');
                    }
                }
            } else {
                return redirect()->route('regiserUserListings')->with('failure', 'Invalid user registration id, please check.');
            }
        } else {
            return redirect()->route('regiserUserListings')->with('failure', 'RegistrationId, SuggestedPropertyId & OldPropertyId should not be empty.');
        }
    }

    //Add by lalit on 31/07/2024 to update register user status as rejected
    public function rejectUserRegistration($id, Request $request)
    {
        if (!empty($id)) {
            $updateStatus = UserRegistration::where('id', $id)->update(['status' => 'rejected', 'remarks' => $request->remarks]);
            if ($updateStatus) {
                return redirect()->route('regiserUserListings')->with('success', 'User registration rejected successfully.');
            } else {
                return redirect()->route('regiserUserListings')->with('failure', 'User registration does not rejected.');
            }
        }
    }

    //Add by lalit on 01/08/2024 to update register user status as under review
    public function reviewUserRegistration($id, Request $request)
    {
        $result = $this->userRegistrationService->moveUnderReviewApplication($id, $request);
        if ($result) {
            return redirect()->route('regiserUserListings')->with('success', 'Application successfully moved to under review.');
        } else {
            return redirect()->route('regiserUserListings')->with('failure', 'Failed to moved to under review. Something went wrong');
        }
    }

    //Add by lalit on 05/08/2024 to show review application listing
    /*public function reviewApplications(Request $request)
    {
        if ($request->ajax()) {
            // $query = ApplicationMovement::query()->with('serviceType')->where('assigned_to', Auth::user()->id)->orderBy('created_at', 'desc');
            // $query = ApplicationMovement::query()->with('serviceType')->where('current_user_id', Auth::id())
            //     ->orderBy('id', 'desc'); // Sort by id in descending order
            // if ($request->has('status')) {
            //     $query->where('status', $request->input('status'));
            // }
            // $data = $query->get()->unique('application_no');// Keep unique application_no
            //Query updated on 07/08/2024
            $query = ApplicationMovement::query()->with('serviceType')
                ->whereIn('id', function ($subQuery) {
                    $subQuery->select(DB::raw('MAX(id)'))
                        ->from('application_movements')
                        ->groupBy('application_no');
                })
                ->where('current_user_id', Auth::id())
                ->orderBy('id', 'desc'); // Sort by id in descending order

            if ($request->has('status')) {
                $query->where('status', $request->input('status'));
            }

            $data = $query->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('search'))) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            $search = Str::lower($request->get('search'));
                            return Str::contains(Str::lower($row['application_no']), $search) ||
                                Str::contains(Str::lower($row['service_type']), $search) ||
                                Str::contains(Str::lower($row['assigned_by']), $search) ||
                                Str::contains(Str::lower($row['remarks']), $search) ||
                                Str::contains(Str::lower($row['status']), $search);
                        });
                    }
                })
                ->addColumn('service_type', function ($row) {
                    return !empty($row->serviceType->item_name) ? ucfirst($row->serviceType->item_name) : '';
                })
                ->addColumn('assigned_by', function ($row) {
                    return !empty($row->assignedBy->name) ? ucfirst($row->assignedBy->name) : '';
                })
                ->editColumn('status', function ($row) {
                    return ucwords($row->status); // Converts user_type to camel case
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . url('review/application/' . $row->id . '/view') . '"><button type="button" class="btn btn-success px-5">View</button></a><br><br>';
                    // if ($row->status == 'new') {
                    //     if (Auth::user()->hasPermissionTo('reject.register.user')) {
                    //         $btn .= '<button type="button" data-bs-toggle="modal" data-bs-target="#rejectUserStatus_' . $row->id . '" class="btn btn-danger px-5">Reject</button>

                    //         <div class="modal fade" id="rejectUserStatus_' . $row->id . '" tabindex="-1" aria-hidden="true">
                    //             <div class="modal-dialog modal-dialog-centered">

                    //                 <div class="modal-content">
                    //                     <form method="post" action="' . route('update.registration.status', ['id' => $row->id]) . '">
                    //                             ' . csrf_field() . '
                    //                             ' . method_field('put') . '
                    //                             <div class="modal-header">
                    //                                 <h5 class="modal-title">Are You Sure?</h5>
                    //                                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    //                             </div>
                    //                             <div class="modal-body">Do you really want to reject this registration? <br>This process cannot be undone.</div>
                    //                             <div class="modal-body input-class-reject">
                    //                                 <lable for="rejection"> Enter remarks for rejections</label>
                    //                                 <textarea name="remarks" class="form-control" placeholder="Enter Remarks"></textarea>
                    //                             </div>
                    //                             <div class="modal-footer">
                    //                                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    //                                     <button type="submit" class="btn btn-danger btn-sm confirm-reject-btn">Confirm Reject</button>
                    //                             </div>
                    //                         </form>
                    //                 </div>

                    //             </div>
                    //         </div>
                    //     ';
                    //     }
                    // }
                    return $btn;
                })
                ->rawColumns(['service_type', 'assigned_by', 'action'])
                ->make(true);
        }
        return view('officials.review_application');
    }*/

    //Add by lalit on 06/08/2024 to get register user details for review page
    /*public function reviewApplicationDetails($id)
    {
        if (!empty($id)) {
            $modelId = ApplicationMovement::where('id', $id)->value('model_id');
            $data = [];
            $regUserDetails = UserRegistration::find($modelId);
            if ($regUserDetails) {
                //Fetch Suggested Property Id from Property Master
                $property = PropertyMaster::where('new_colony_name', $regUserDetails->locality)->where('block_no', $regUserDetails->block)->where('plot_or_property_no', $regUserDetails->plot)->first();
                if (!empty($property['id'])) {
                    $data['suggestedPropertyId'] = $property['id'];
                    $data['oldPropertyId'] = $property['old_propert_id'];
                } else {
                    $data['suggestedPropertyId'] = '';
                    $data['oldPropertyId'] = '';
                    // $data['oldPropertyId'] = $property['id'];
                }
                $data['details'] = $regUserDetails;
                $data['applicationMovementId'] = $id;
                return view('officials.review_application_details', compact('data'));
            }
        }
    }*/

    //Add by lalit on 06/08/2024 to approve review application
    public function approvedReviewApplication(Request $request)
    {
        if (!empty($request->applicationMovementId) && !empty($request->remarks)) {
            $result = $this->userRegistrationService->approveReviewRequest($request);
            if ($result) {
                // return redirect()->route('reviewApplicationsListings')->with('success', 'Application request approved successfully.');
                return redirect()->back()->with('success', 'Application request approved successfully.');
            } else {
                // return redirect()->route('reviewApplicationsListings')->with('failure', 'Failed approve application request.');
                return redirect()->back()->with('failure', 'Failed approve application request.');
            }
        } else {
            // return redirect()->route('reviewApplicationsListings')->with('failure', 'ApplicationId & Remarks should not be empty.');
            return redirect()->back()->with('failure', 'ApplicationId & Remarks should not be empty.');
        }
    }

    /*public function applicantNewPropertiesOld(Request $request)
    {
        // Get the logged-in user
        $user = Auth::user();
        $filterPermissionArr = [];
        $permissionMap = [
            'view.registration.new' => 'RS_NEW',
            'view.registration.approved' => 'RS_APP',
            'view.registration.rejected' => 'RS_REJ',
            'view.registration.under_review' => 'RS_UREW',
            'view.registration.reviewed' => 'RS_REW',
            'view.registration.pending' => 'RS_PEN',
        ];

        $allPermissions = $user->getAllPermissions();
        foreach ($allPermissions as $permission) {
            if (isset($permissionMap[$permission->name])) {
                $filterPermissionArr[] = $permissionMap[$permission->name];
            }
        }

        if (!empty($filterPermissionArr)) {
            $items = Item::where('group_id', 17000)
                ->whereIn('item_code', $filterPermissionArr)
                ->get();
        }


        $sections = $user->sections->pluck('id');

        if ($request->ajax()) {

            $dataWithPagination = NewlyAddedProperty::query()
                ->when($request->status, function ($q) use ($request) {
                    $q->where('newly_added_properties.status', $request->status);
                })
                ->with('oldColony')
                ->leftJoin('application_movements', function ($join) {
                    $join->on('newly_added_properties.applicant_number', '=', 'application_movements.application_no')
                        ->whereIn('application_movements.id', function ($subQuery) {
                            $subQuery->select(DB::raw('MAX(id)'))
                                ->from('application_movements')
                                ->groupBy('application_no');
                        });
                })
                ->leftJoin('users as assigned_by_user', 'application_movements.assigned_by', '=', 'assigned_by_user.id')
                ->leftJoin('users as assigned_to_user', 'application_movements.assigned_to', '=', 'assigned_to_user.id')
                ->leftJoin('users', 'newly_added_properties.user_id', '=', 'users.id')
                ->leftJoin('items', 'newly_added_properties.status', '=', 'items.id')
                ->select(
                    'newly_added_properties.*',
                    'users.name as name',
                    'items.item_name',
                    'items.item_code',
                    'application_movements.assigned_by',
                    'assigned_by_user.name as assigned_by_name',
                    'application_movements.assigned_to',
                    'assigned_to_user.name as assigned_to_name',
                )
                ->whereIn('section_id', $sections)
                ->orderBy('newly_added_properties.created_at', 'desc')->latest()->paginate(20);
            return view('officials.applicant.child', compact(['dataWithPagination', 'items']));
        }
        $dataWithPagination = Self::getApplicantNewProperties($user, $sections);
        return view('officials.applicant.index', compact(['dataWithPagination', 'items']));
    }*/

    public function applicantNewProperties(Request $request)
    {
        $user = Auth::user();
        $filterPermissionArr = [];
        $permissionMap = [
            'view.registration.new' => 'RS_NEW',
            'view.registration.approved' => 'RS_APP',
            'view.registration.rejected' => 'RS_REJ',
            'view.registration.under_review' => 'RS_UREW',
            'view.registration.reviewed' => 'RS_REW',
            'view.registration.pending' => 'RS_PEN',
        ];

        $allPermissions = $user->getAllPermissions();
        foreach ($allPermissions as $permission) {
            if (isset($permissionMap[$permission->name])) {
                $filterPermissionArr[] = $permissionMap[$permission->name];
            }
        }

        if (!empty($filterPermissionArr)) {
            $items = Item::where('group_id', 17000)
                ->whereIn('item_code', $filterPermissionArr)
                ->get();
        }
        return view('officials.applicant.indexDatatable', compact('items'));
    }

    public function getApplicantPropertyListings(Request $request)
    {
        // Get the logged-in user
        $user = Auth::user();
        $sections = $user->sections->pluck('id');

        // Define the query outside of the AJAX block
        $query = NewlyAddedProperty::query()
            ->with('oldColony')
            ->leftJoin('application_movements', function ($join) {
                $join->on('newly_added_properties.applicant_number', '=', 'application_movements.application_no')
                    ->whereIn('application_movements.id', function ($subQuery) {
                        $subQuery->select(DB::raw('MAX(id)'))
                            ->from('application_movements')
                            ->groupBy('application_no');
                    });
            })
            ->leftJoin('users as assigned_by_user', 'application_movements.assigned_by', '=', 'assigned_by_user.id')
            ->leftJoin('users as assigned_to_user', 'application_movements.assigned_to', '=', 'assigned_to_user.id')
            ->leftJoin('users', 'newly_added_properties.user_id', '=', 'users.id')
            ->leftJoin('items', 'newly_added_properties.status', '=', 'items.id')
            ->leftJoin('old_colonies', 'newly_added_properties.locality', '=', 'old_colonies.id')
            ->select(
                'newly_added_properties.*',
                'newly_added_properties.applicant_number',
                'users.name as name',
                'newly_added_properties.block',
                'newly_added_properties.plot',
                'old_colonies.name as old_colony_name',
                'newly_added_properties.remarks',
                'items.item_name',
                'items.item_code',
                DB::raw("CONCAT_WS('/', newly_added_properties.block, newly_added_properties.plot, old_colonies.name) as property_details"),
                'newly_added_properties.created_at',
            )
            ->whereIn('section_id', $sections);

        // Apply status filter if provided
        if ($request->status) {
            $query->where('newly_added_properties.status', $request->status);
        }

        // Apply status condition based on user role
        $query->when($request->status || $user->roles[0]['name'] == 'deputy-lndo', function ($q) use ($request, $user) {
            if ($user->roles[0]['name'] == 'deputy-lndo') {
                $q->where('newly_added_properties.status', $request->status ?? getStatusName('RS_UREW'));
            } else {
                $q->where('newly_added_properties.status', $request->status);
            }
        });

        // Define the columns that can be ordered
        $columns = ['id', 'applicant_number', 'name', 'property_details', 'remarks', 'status', 'created_at'];

        $totalData = $query->count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        if($request->input('order.0.column')){
            $orderColumnIndex = $request->input('order.0.column');
            $order = $columns[$orderColumnIndex] ?? 'id'; // Use 'id' as default if index is out of bounds
            $dir = $request->input('order.0.dir');
        } else {
            $order = $columns['7'] ?? 'id'; // Use 'id' as default if index is out of bounds
            $dir = 'desc';
        }

        if (!empty($request->input('search.value'))) {
            $search = $request->input('search.value');
            $query->where(function ($q) use ($search) {
                $q->where('newly_added_properties.applicant_number', 'LIKE', "%{$search}%")
                    ->orWhere('users.name', 'LIKE', "%{$search}%")
                    ->orWhere(function ($q) use ($search) {
                        $q->where('newly_added_properties.block', 'LIKE', "%{$search}%")
                            ->orWhere('newly_added_properties.plot', 'LIKE', "%{$search}%")
                            ->orWhere('old_colonies.name', 'LIKE', "%{$search}%");
                    })
                    ->orWhere('newly_added_properties.remarks', 'LIKE', "%{$search}%");
            });

            $totalFiltered = $query->count();
        }

        $getNewPropertyDetails = $query->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        $data = [];
        foreach ($getNewPropertyDetails as $getNewPropertyDetail) {
            $nestedData['id'] = $getNewPropertyDetail->id;
            $nestedData['applicant_number'] = $getNewPropertyDetail->applicant_number;
            $nestedData['name'] = $getNewPropertyDetail->name;
            $nestedData['property_details'] = ucfirst($getNewPropertyDetail->block) . '/' . ucfirst($getNewPropertyDetail->plot) . '/' . ucfirst($getNewPropertyDetail->old_colony_name);
            $nestedData['documents'] = [
                'sale_deed_doc' => $getNewPropertyDetail->sale_deed_doc,
                'builder_buyer_agreement_doc' => $getNewPropertyDetail->builder_buyer_agreement_doc,
                'lease_deed_doc' => $getNewPropertyDetail->lease_deed_doc,
                'substitution_mutation_letter_doc' => $getNewPropertyDetail->substitution_mutation_letter_doc,
                'other_doc' => $getNewPropertyDetail->other_doc,
                'owner_lessee_doc' => $getNewPropertyDetail->owner_lessee_doc,
                'authorised_signatory_doc' => $getNewPropertyDetail->authorised_signatory_doc,
                'chain_of_ownership_doc' => $getNewPropertyDetail->chain_of_ownership_doc,
            ];

            $nestedData['remark'] = [
                'remark' => !empty($getNewPropertyDetail->remarks) ? strip_tags($getNewPropertyDetail->remarks) : 'NA',
                'assigned_by_name' => !empty($getNewPropertyDetail->assigned_by_name) ? $getNewPropertyDetail->assigned_by_name : 'NA'
            ];
            $statusClasses = [
                'RS_REJ' => 'text-danger bg-light-danger',
                'RS_NEW' => 'text-primary bg-light-primary',
                'RS_UREW' => 'text-warning bg-light-warning',
                'RS_REW' => 'text-white bg-secondary',
                'RS_PEN' => 'text-info bg-light-info',
                'RS_APP' => 'text-success bg-light-success',
            ];
            $class = $statusClasses[$getNewPropertyDetail->item_code] ?? 'text-secondary bg-light';
            $nestedData['status'] = '<div class="badge rounded-pill ' . $class . ' p-2 text-uppercase px-3">' . ucwords($getNewPropertyDetail->item_name) . '</div>';
            $nestedData['created_at'] = $getNewPropertyDetail->created_at->format('Y-m-d H:i:s');
            $nestedData['action'] = '<a href="' . url('applicant/property/' . $getNewPropertyDetail->id . '/view') . '">
            <button type="button" class="btn btn-success px-5">View</button>
        </a>';
            $data[] = $nestedData;
        }

        $json_data = [
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        ];

        return response()->json($json_data);
    }

    //Add by lalit on 21/08/2024 to show register user listing
    public function getApplicantNewProperties($user, $sections)
    {
        // Base query builder
        $query = NewlyAddedProperty::with('oldColony')
            ->leftJoin('application_movements', function ($join) {
                $join->on('newly_added_properties.applicant_number', '=', 'application_movements.application_no')
                    ->whereIn('application_movements.id', function ($subQuery) {
                        $subQuery->select(DB::raw('MAX(id)'))
                            ->from('application_movements')
                            ->groupBy('application_no');
                    });
            })
            ->leftJoin('users as assigned_by_user', 'application_movements.assigned_by', '=', 'assigned_by_user.id')
            ->leftJoin('users as assigned_to_user', 'application_movements.assigned_to', '=', 'assigned_to_user.id')
            ->leftJoin('users', 'newly_added_properties.user_id', '=', 'users.id')
            ->leftJoin('items', 'newly_added_properties.status', '=', 'items.id')
            ->select(
                'newly_added_properties.*',
                'users.name as name',
                'items.item_name',
                'items.item_code',
                'application_movements.assigned_by',
                'assigned_by_user.name as assigned_by_name',
                'application_movements.assigned_to',
                'assigned_to_user.name as assigned_to_name'
            )
            ->whereIn('section_id', $sections)
            ->orderBy('newly_added_properties.created_at', 'desc');

        // Adjust query based on user role
        if ($user->roles[0]['name'] == 'deputy-lndo') {
            $query->where('newly_added_properties.status', getStatusName('RS_UREW'));
        }

        // Paginate results
        $dataWithPagination = $query->paginate(20);

        return $dataWithPagination;
    }

    //Add by lalit on 21/08/2024 to get new property details
    public function newPropertyDetails($id)
    {
        if (!empty($id)) {

            // Retrieve the user's roles
            $roles = Auth::user()->roles[0]->name;
            $data = [];
            $regUserDetails = NewlyAddedProperty::with(['applicantDetails', 'user'])->find($id);
            if ($regUserDetails) {
                //Fetch Suggested Property Id from Property Master
                $property = PropertyMaster::where('new_colony_name', $regUserDetails->locality)->where('block_no', $regUserDetails->block)->where('plot_or_property_no', $regUserDetails->plot)->first();
                if (!empty($property['id'])) {
                    $data['propertyMasterId'] = $property['id'];
                    $data['suggestedPropertyId'] = $property['old_propert_id'];
                    $data['oldPropertyId'] = $property['old_propert_id'];
                } else {
                    $data['propertyMasterId'] = '';
                    $data['suggestedPropertyId'] = '';
                    $data['oldPropertyId'] = '';
                }
                $data['details'] = $regUserDetails;
                $data['applicationMovementId'] = $id;
                $checkList = ApplicationStatus::where('service_type', getServiceType('RS_NEW_PRO'))->where('model_id', $id)->first();
                return view('officials.applicant.details', compact('data', 'roles', 'checkList'));
            }
        }
    }

    //Add by lalit on 21/08/2024 to update register user status as under review
    public function reviewApplicantNewProperty($id, Request $request)
    {
        $result = $this->userRegistrationService->moveUnderReviewNewProperty($id, $request);
        if ($result) {
            return redirect()->route('applicantNewProperties')->with('success', 'Property successfully moved to under review.');
        } else {
            return redirect()->route('applicantNewProperties')->with('failure', 'Failed to moved to under review. Something went wrong');
        }
    }

    //Add by lalit on 21/08/2024 to approve review application
    public function approvedReviewApplicantNewProperty(Request $request)
    {
        if (!empty($request->applicationMovementId) && !empty($request->remarks)) {
            $result = $this->userRegistrationService->approveReviewNewPropertyRequest($request);
            if ($result) {
                // return redirect()->route('reviewApplicationsListings')->with('success', 'Application request approved successfully.');
                return redirect()->back()->with('success', 'Application request approved successfully.');
            } else {
                // return redirect()->route('reviewApplicationsListings')->with('failure', 'Failed approve application request.');
                return redirect()->back()->with('failure', 'Failed approve application request.');
            }
        } else {
            // return redirect()->route('reviewApplicationsListings')->with('failure', 'ApplicationId & Remarks should not be empty.');
            return redirect()->back()->with('failure', 'ApplicationId & Remarks should not be empty.');
        }
    }

    //Add by lalit on 31/07/2024 to update register user status
    public function rejectApplicantNewProperty($id, Request $request)
    {
        if (!empty($id)) {
            // DB::transaction(function () use ($id, $request) {
            $updateStatus = NewlyAddedProperty::where('id', $id)->update(['status' => getStatusName('RS_REJ'), 'remarks' => $request->remarks]);
            if ($updateStatus) {
                $getPropertyDetailsObj =  NewlyAddedProperty::where('id', $id)->first();
                $applicationMovement = ApplicationMovement::create([
                    'assigned_by'           => Auth::user()->id,
                    'service_type'          => getServiceType('RS_NEW_PRO'),
                    'model_id'              => $id,
                    'status'                => getStatusName('RS_REJ'),
                    'application_no'        => $getPropertyDetailsObj->applicant_number,
                    'remarks'               => $request->remarks
                ]);
                if ($applicationMovement) {
                    ApplicationStatus::create([
                        'service_type'              => getServiceType('RS_NEW_PRO'),
                        'model_id'                  => $id,
                        'reg_app_no'                => $getPropertyDetailsObj->applicant_number,
                        'is_mis_checked'            => $request->is_mis_checked ? true : false,
                        'is_scan_file_checked'      => $request->is_scan_file_checked ? true : false,
                        'is_uploaded_doc_checked'   => $request->is_uploaded_doc_checked ? true : false,
                        'created_by'                => Auth::user()->id,
                    ]);
                    $getUserDetailsObj =  User::find($getPropertyDetailsObj->user_id);
                    if ($getUserDetailsObj) {
                        $data = [
                            'name' => $getUserDetailsObj->name,
                            'email' => $getUserDetailsObj->email,
                            'regNo' => $getPropertyDetailsObj->applicant_number,
                            'remark' => $request->remarks
                        ];
                        $action = 'REG_REJ';
                        $this->settingsService->applyMailSettings($action);
                        Mail::to($getUserDetailsObj->email)->send(new CommonMail($data, $action));
                        $this->communicationService->sendSmsMessage($data, $getUserDetailsObj->mobile_no, $action);
                        $this->communicationService->sendWhatsAppMessage($data, $getUserDetailsObj->mobile_no, $action);
                    }
                    return redirect()->back()->with('success', 'Applicant property rejected successfully.');
                };
            } else {
                return redirect()->back()->with('failure', 'Applicant property does not rejected.');
            }
            // });
        }
    }

    //Add by lalit on 21/08/2024 to approve user registeration
    public function approvedApplicantNewProperty(Request $request)
    {
        if (!empty($request->newlyAddedPropertyId) && !empty($request->suggestedPropertyId) && !empty($request->oldPropertyId)) {
            $getNewlyAddedPropertyDetails = NewlyAddedProperty::find($request->newlyAddedPropertyId);
            if (!empty($getNewlyAddedPropertyDetails->id)) {
                if ($getNewlyAddedPropertyDetails->status == getStatusName('RS_APP')) {
                    return redirect()->route('applicantNewProperties')->with('success', 'Property has been already approved.');
                } else {
                    $result = $this->userRegistrationService->approveApplicantNewProperty($request);
                    if ($result) {
                        return redirect()->route('applicantNewProperties')->with('success', 'Applicant new property approved successfully.');
                    } else {
                        return redirect()->route('applicantNewProperties')->with('failure', 'Failed to approve applicant property.');
                    }
                }
            } else {
                return redirect()->route('applicantNewProperties')->with('failure', 'Invalid property id, please check.');
            }
        } else {
            return redirect()->route('applicantNewProperties')->with('failure', 'RegistrationId, SuggestedPropertyId & OldPropertyId should not be empty.');
        }
    }


    //for checking is property free before approving
    public function checkProperty($id)
    {
        $isPropertyFree = GeneralFunctions::isPropertyFree($id);
        $status = $isPropertyFree['success'];
        $message = $isPropertyFree['message'];
        $details = $isPropertyFree['details'];
        return response()->json(['success' => $status, 'message' => $message, 'details' => $details]);
    }
}
