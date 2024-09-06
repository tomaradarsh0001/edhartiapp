<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Otp;
use App\Models\OldColony;
use App\Models\UserRegistration;
use App\Models\PropertySectionMapping;
use App\Models\Template;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Services\ColonyService;
use App\Services\MisService;
use App\Services\CommunicationService;
use App\Helpers\GeneralFunctions;
use App\Services\SettingsService;


use App\Mail\OtpVerification;
use App\Mail\SuccessfullRegistration;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

use App\Mail\CommonMail;

class RegisteredUserController extends Controller
{
    protected $communicationService;
    protected $settingsService;
    
    public function __construct(CommunicationService $communicationService, SettingsService $settingsService)
    {
        $this->communicationService = $communicationService;
        $this->settingsService = $settingsService;
    }
    
    /**
     * Display the registration view.
     */ 
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->syncRoles('user');

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }


    public function publicRegister(ColonyService $colonyService, MisService $misService)
    {
        $colonyList = $colonyService->getColonyList();
        $propertyTypes = $misService->getItemsByGroupId(1052);
        return view('auth.public-register', compact(['colonyList', 'propertyTypes']));
    }

    public function publicRegisterCreate(Request $request, CommunicationService $communicationService)
    {
        //  dd($request->all());
        try {
            if (isset($request->purposeReg)) {
                $purposeOfRegistration = $request->purposeReg;
                if (isset($request->newUser)) {
                    $prefix = '';
                    if ($request->newUser == 'propertyowner') {
                        $userType     = 'individual';
                        $name         = $request->nameInv;
                        $email        = $request->emailInv;
                        $mobileNo     = $request->mobileInv;
                        $consent      = $request->consentInv;
                        $aadhar       = $request->adharnumberInv;
                        $remark       = $request->remarkInv;
                        $saleDeedDoc  = $request->saleDeedDocInv;
                        $BuilAgreeDoc = $request->BuilAgreeDocInv;
                        $leaseDeedDoc = $request->leaseDeedDocInv;
                        $subMutLtrDoc = $request->subMutLtrDocInv;
                        $otherDoc     = $request->otherDocInv;
                        $prefix       = $request->prefixInv;
                        $propertyDetailsFilled = $request->propertyId;
                        if (isset($request->propertyId)) {
                            $locality   = $request->localityInvFill;
                            $block      = $request->blocknoInvFill;
                            $plot       = $request->plotnoInvFill;
                            $knownAs    = $request->knownasInvFill;
                            $landUseType    = $request->landUseInvFill;
                            $landUseSubType    = $request->landUseSubtypeInvFill;
                        } else {
                            $locality   = $request->localityInv;
                            $block      = $request->blockInv;
                            $plot       = $request->plotInv;
                            $knownAs    = $request->knownasInv;
                            $landUseType    = $request->landUseInv;
                            $landUseSubType    = $request->landUseSubtypeInv;
                        }
                    } else {
                        $userType     = 'organization';
                        $name         = $request->nameauthsignatory;
                        $email        = $request->emailauthsignatory;
                        $mobileNo     = $request->mobileauthsignatory;
                        $consent      = $request->consentOrg;
                        $aadhar       = $request->orgAddharNo;
                        $remark       = $request->remarkOrg;
                        $saleDeedDoc  = $request->saleDeedOrg;
                        $BuilAgreeDoc = $request->builBuyerAggrmentDoc;
                        $leaseDeedDoc = $request->leaseDeedDoc;
                        $subMutLtrDoc = $request->subMutLetterDoc;
                        $otherDoc     = $request->otherDoc;
                        $propertyDetailsFilled = $request->propertyIdOrg;
                        if (isset($request->propertyIdOrg)) {
                            $locality   = $request->localityOrgFill;
                            $block      = $request->blocknoOrgFill;
                            $plot       = $request->plotnoOrgFill;
                            $knownAs    = $request->knownasOrgFill;
                            $landUseType    = $request->landUseOrgFill;
                            $landUseSubType    = $request->landUseSubtypeOrgFill;
                        } else {
                            $locality   = $request->localityOrg;
                            $block      = $request->blockOrg;
                            $plot       = $request->plotOrg;
                            $knownAs    = $request->knownasOrg;
                            $landUseType    = $request->landUseOrg;
                            $landUseSubType    = $request->landUseSubtypeOrg;
                        }
                    }
                   
                    $section = PropertySectionMapping::where('colony_id', $locality)
                        ->where('property_type', $landUseType)
                        ->where('property_subtype', $landUseSubType)
                        ->pluck('section_id')->first();

                    if (!isset($section)) {
                        $section  = 0;
                    }

                    $isEmailMobileVeified = Otp::where('email', $email)
                        ->where('is_email_verified', '1')
                        ->where('mobile', $mobileNo)
                        ->where('is_mobile_verified', '1')
                        ->first();
                    if ($isEmailMobileVeified) {
                        $ownLeaseDoc = '';
                        $authSignatoryDoc = '';
                        //get unique registration number
                        $registrationNumber = GeneralFunctions::generateRegistrationNumber();
                        $date = now()->format('Y-m-d');
                        $colony = OldColony::find($locality);
                        $colonyCode = $colony->code;
                        if (isset($saleDeedDoc)) {
                            $saleDeedDoc = GeneralFunctions::uploadFile($saleDeedDoc, $registrationNumber.'/'.$colonyCode.'/registration', 'saledeed');
                        }
                        if (isset($BuilAgreeDoc)) {
                            $builAgreeDoc = GeneralFunctions::uploadFile($BuilAgreeDoc, $registrationNumber.'/'.$colonyCode.'/registration', 'BuilderAgreement');
                        }
                        if (isset($leaseDeedDoc)) {
                            $leaseDeedDoc = GeneralFunctions::uploadFile($leaseDeedDoc, $registrationNumber.'/'.$colonyCode.'/registration', 'leaseDeed');
                        }
                        if (isset($subMutLtrDoc)) {
                            $subMutLtrDoc = GeneralFunctions::uploadFile($subMutLtrDoc, $registrationNumber.'/'.$colonyCode.'/registration', 'subsMutLetter');
                        }
                        if (isset($otherDoc)) {
                            $otherDoc = GeneralFunctions::uploadFile($otherDoc, $registrationNumber.'/'.$colonyCode.'/registration', 'otherDocuments');
                        }
                        if (isset($request->ownLeaseDocInv)) {
                            $ownLeaseDoc = GeneralFunctions::uploadFile($request->ownLeaseDocInv, $registrationNumber.'/'.$colonyCode.'/registration', 'ownerLessee');
                        }
                        if (isset($request->propDoc)) {
                            $authSignatoryDoc = GeneralFunctions::uploadFile($request->propDoc, $registrationNumber.'/'.$colonyCode.'/registration', 'ownerLessee');
                        }
                        $userRegistration = UserRegistration::create([
                            'applicant_number' => $registrationNumber,
                            'status' => getStatusName('RS_NEW'),
                            'purpose_of_registation' => $purposeOfRegistration,
                            'user_type' => $userType,
                            'name' => $name,
                            'gender' => $request->genderInv ? $request->genderInv : '',
                            'prefix' => $prefix,
                            'second_name' => $request->secondnameInv ? $request->secondnameInv : '',
                            'mobile' => $mobileNo,
                            'email' => $email,
                            'pan_number' => $request->pannumberInv ? $request->pannumberInv : '',
                            'aadhar_number' => $aadhar,
                            'user_remark' => $remark,
                            'comm_address' => $request->commAddressInv ? $request->commAddressInv : '',
                            'is_property_id_known' => $propertyDetailsFilled,
                            'locality' => $locality,
                            'block' => $block,
                            'plot' => $plot,
                            'known_as' => $knownAs,
                            'land_use_type' => $landUseType,
                            'land_use_sub_type' => $landUseSubType,
                            'section_id' => $section,
                            'organization_name' => $request->nameOrg ? $request->nameOrg : '',
                            'organization_pan_card' => $request->pannumberOrg ? $request->pannumberOrg : '',
                            'organization_address' => $request->orgAddressOrg ? $request->orgAddressOrg : '',
                            'sale_deed_doc' => $saleDeedDoc,
                            'builder_buyer_agreement_doc' => $builAgreeDoc,
                            'lease_deed_doc' => $leaseDeedDoc,
                            'substitution_mutation_letter_doc' => $subMutLtrDoc,
                            'other_doc' => $otherDoc,
                            'owner_lessee_doc' => $ownLeaseDoc,
                            'authorised_signatory_doc' => $authSignatoryDoc,
                            'chain_of_ownership_doc' => '',
                            'consent' => $consent
                        ]);

                        
                        
                        if ($userRegistration) {
                            $data = [
                              'name' => $name,
                              'email' => $email,
                              'regNo' => $registrationNumber
                            ];
                            $action = 'REG_SUC';
                            // Apply the mail settings before sending the email
                            $this->settingsService->applyMailSettings($action);
                            $mailSent = Mail::to($email)->send(new CommonMail($data,$action));
                            $communicationService->sendSmsMessage($data,$mobileNo,$action);
                            $communicationService->sendWhatsAppMessage($data,$mobileNo,$action);

                            return redirect()->back()->with('success', 'You are Registared successfully, and your registration no. is:- ' . $registrationNumber);
                        } else {
                            return redirect()->back()->with('failure', 'Registration not successfull');
                        }
                    } else {
                        return redirect()->back()->with('failure', 'You email or mobile not verified. Please verify.');
                    }
                } else {
                    return redirect()->back()->with('failure', 'Property Type not available');
                }
            }
        } catch (\Exception $e) {
            Log::info($e);
            return redirect()->back()->with('failure', $e->getMessage());
        }
    }


    //To send and store the otp - Sourav Chauhan (25/july/2024)
    public function saveOtp(Request $request,CommunicationService $communicationService)
    {
        try {
            if (isset($request->mobile)) {
                $isMobileAvailable = Otp::where('mobile', $request->mobile)->where('is_mobile_verified', '1')->first();
                
                if (!$isMobileAvailable) {
                    $generateOtp = GeneralFunctions::generateUniqueRandomNumber(4);
                    
                    if (isset($request->emailToVerify)) {
                        $isEmailVerified = Otp::where('email', $request->emailToVerify)->first();
                        if ($isEmailVerified) {
                            $isEmailVerified->mobile = $request->mobile;
                            $isEmailVerified->mobile_otp = $generateOtp;
                            $isEmailVerified->mobile_otp_sent_at = now();
                            if($isEmailVerified->save()){

                                $action = 'OTP_VALID';
                                $data = [
                                    'otp' => $generateOtp
                                ];
                                $communicationService->sendSmsMessage($data,$request->mobile,$action);
                                $communicationService->sendWhatsAppMessage($data,$request->mobile,$action);
                                return response()->json(['success' => true, 'message' => 'OTP sent to mobile number ' . $request->mobile . ' successfully']);
                            } else {
                                return response()->json(['success' => false, 'message' => 'Failed to send OTP']);
                            }
                        }
                    }

                    // Create or update OTP record for the mobile
                    $otp = Otp::updateOrCreate(
                        ['mobile' => $request->mobile],
                        ['mobile_otp' => $generateOtp, 'mobile_otp_sent_at' => now()]
                    );
                    if ($otp) {
                        $action = 'OTP_VALID';
                        $data = [
                            'otp' => $generateOtp
                        ];
                        $communicationService->sendSmsMessage($data,$request->mobile,$action);
                        $communicationService->sendWhatsAppMessage($data,$request->mobile,$action);
                        return response()->json(['success' => true, 'message' => 'OTP sent to mobile number ' . $request->mobile . ' successfully']);
                    } else {
                        return response()->json(['success' => false, 'message' => 'Failed to send OTP']);
                    }
                } else {
                    return response()->json(['success' => false, 'message' => 'Mobile already in use']);
                }
            } else {
                //for email otp
                $isEmailAvailable = Otp::where('email', $request->email)->where('is_email_verified', '1')->first();

                if (!$isEmailAvailable) {
                    $generateOtp = GeneralFunctions::generateUniqueRandomNumber(4);

                    // Apply the mail settings before sending the email
                    $action = 'OTP_VALID';
                    $this->settingsService->applyMailSettings($action);
                    $data = [
                        'otp' => $generateOtp
                    ];
                    $mailSent = Mail::to($request->email)->send(new CommonMail($data,$action));

                    if ($mailSent) {
                        if (isset($request->mobileToVerify)) {
                            $isMobileVerified = Otp::where('mobile', $request->mobileToVerify)->first();
                            if ($isMobileVerified) {
                                $isMobileVerified->email = $request->email;
                                $isMobileVerified->email_otp = $generateOtp;
                                $isMobileVerified->email_otp_sent_at = now();
                                $isMobileVerified->save();
                                return response()->json(['success' => true, 'message' => 'OTP sent to email ' . $request->email . ' successfully']);
                            }
                        }
                        // Create or update OTP record for the email
                        $otp = Otp::updateOrCreate(
                            ['email' => $request->email],
                            ['email_otp' => $generateOtp, 'email_otp_sent_at' => now()]
                        );

                        if ($otp) {
                            return response()->json(['success' => true, 'message' => 'OTP sent to email ' . $request->email . ' successfully']);
                        } else {
                            return response()->json(['success' => false, 'message' => 'Failed to send OTP']);
                        }
                    } else {
                        return response()->json(['success' => false, 'message' => 'Failed to send OTP']);
                    }
                } else {
                    return response()->json(['success' => false, 'message' => 'Email already in use']);
                }
            }
        } catch (\Exception $e) {
            Log::info($e);
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }


    //To verify the otp - Sourav Chauhan (25/july/2024)
    public function verifyOtp(Request $request)
    {
        try {
            if (isset($request->mobileOtp)) {
                $databaseOtp = Otp::where('mobile', $request->mobile)->where('mobile_otp', $request->mobileOtp)->first();
                if ($databaseOtp) {
                    $databaseOtp->is_mobile_verified = '1';
                    $databaseOtp->mobile_otp = null;
                    if ($databaseOtp->save()) {
                        return response()->json(['success' => true, 'message' => 'Mobile number ' . $request->mobile . ' verified successfully']);
                    } else {
                        return response()->json(['success' => false, 'message' => 'Mobile number not verified']);
                    }
                } else {
                    return response()->json(['success' => false, 'message' => 'Otp not matched. Please enter correct otp']);
                }
            } else if ($request->emailOtp) {
                //email otp
                $databaseOtp = Otp::where('email', $request->email)->where('email_otp', $request->emailOtp)->first();
                if ($databaseOtp) {
                    $databaseOtp->is_email_verified = '1';
                    $databaseOtp->email_otp = null;
                    if ($databaseOtp->save()) {
                        return response()->json(['success' => true, 'message' => 'Email ' . $request->email . ' verified successfully']);
                    } else {
                        return response()->json(['success' => false, 'message' => 'Email not verified']);
                    }
                } else {
                    return response()->json(['success' => false, 'message' => 'Otp not matched. Please enter correct otp']);
                }
            }
        } catch (\Exception $e) {
            Log::info($e);
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
