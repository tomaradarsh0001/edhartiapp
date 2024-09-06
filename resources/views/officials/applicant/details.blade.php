@extends('layouts.app')

@section('title', 'Applicant Other Property Details')

@section('content')
    <style>
        .pagination .active a {
            color: #ffffff !important;
        }

        .required-error-message {
            display: none;
        }

        .required-error-message {
            margin-left: -1.5em;
            margin-top: 3px;
        }

        .form-check-inputs[type=checkbox] {
            border-radius: .25em;
        }

        .form-check .form-check-inputs {
            float: left;
            margin-left: -1.5em;
        }

        .form-check-inputs {
            width: 1.5em;
            height: 1.5em;
            margin-top: 0;
        }
        .property-table-infos {
    font-size: 16px;
}
h4.suggestedpropertytitle {
    font-size: 18px;
}
.grid-icons {
    font-size: 110px;
}
.doc-item {
    width: 140px;
    height: 145px;
    margin: 0px auto 15px;
    text-align: center;
}
.doc-item label {
    position: relative;
    width: 100%;
    height: 100%;
    border: 1px solid #e7e7e7;
    border-radius: 5px;
    background: #f5f5f5;
    display: flex;
    align-items: center;
    justify-content: center;
}

i.download_view {
    width: 25px;
    height: 25px;
    background-color: #116d6e;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 5px;
    font-size: 18px;
}
input.property-document-approval-chk {
    width: 25px;
    height: 25px;
}
.grid-icon-group {
    position: absolute;
    top: 5px;
    right: 0px;
    display: flex;
    align-items: center;
    z-index: 9;
}
.grid-section {
    display: grid;
    grid-template-columns: repeat(8, 1fr);
    gap: 15px;
}
.view_docs {
    font-size: 28px;
    margin-right: 2px;
}
h5.icon-label {
    position: absolute;
    bottom: 0px;
    margin: 0px;
    width: 100%;
    background: #c1c1c1d9;
    padding: 5px;
    font-size: 16px;
}
    </style>
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">APPLICANT</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item">Other</li>
                    <li class="breadcrumb-item active" aria-current="page">Property Details</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- <div class="ms-auto"><a href="#" class="btn btn-primary">Button</a></div> -->

    <hr>
    <div class="card">
        <div class="card-body">
        <h5 class="text-primary"><strong>Registration ID: </strong> {{ $data['details']->applicant_number ?? '' }}</h5>
        <table class="table table-bordered property-table-infos mb-0 mt-3">
            <tr>
                <td><strong>Fullname:</strong> {{ $data['details']->user->name ?? '' }}</td>
                <td><strong>Registration Type:</strong> {{ $data['details']->user->user_type ?? '' }}</td>
                <td><strong>Email:</strong> {{ $data['details']->user->email ?? '' }}</td>
                <td><strong>Mobile:</strong> {{ $data['details']->user->mobile_no ?? '' }}</td>
            </tr>
          
            <tr>
                <td><strong>PAN:</strong> {{ $data['details']->applicantDetails->pan_card ?? '' }}</td>
                <td><strong>Aadhar:</strong> {{ $data['details']->applicantDetails->aadhar_card ?? '' }}</td>
                @if (!empty($data['details']->applicantDetails->organization_name))
                <td><strong>Organization Name:</strong> {{ $data['details']->applicantDetails->organization_name ?? '' }}</td>
                <td><strong>Organization PAN:</strong> {{ $data['details']->applicantDetails->organization_pan_card ?? '' }}</td>
                @endif
            </tr>
        </table>
        
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <!-- <div class="part-title">
                <h5>USER DETAILS</h5>
            </div> -->
            <div class="part-title mt-2">
                <h5>PROPERTY DOCUMENT DETAILS</h5>
            </div>
            <div class="part-details">
                <div class="container-fluid">
                    <div class="grid-section">

                        <div class="doc-item">
                            <label for="saleDeedDoc">
                                <div class="grid-icon-group">
                                    <a href="{{ asset('storage/' . $data['details']->sale_deed_doc ?? '') }}" target="_blank" class="view_docs" data-toggle="tooltip"
                                        title="View Uploaded Files"><i class='bx bx-download download_view'></i></a>
                                        <div class="form-check form-check-success pl-0">
                                        <input class="form-check-input property-document-approval-chk" type="checkbox"
                                        role="switch" id="saleDeedDoc"
                                        @if ($checkList && $checkList->is_uploaded_doc_checked == 1) checked disabled @endif
                                        @if ($checkList) disabled @endif
                                        @if ($roles === 'deputy-lndo') disabled @endif> </div>
                                </div>
                                <i class="text-danger bx bxs-file-pdf grid-icons"></i>
                                <h5 class="icon-label">Sale Deed</h5>
                                           
                            </label>
                        </div>
                        
                    </div>
                    <table class="table table-bordered property-table-info">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Document Name</th>
                                <th style="text-align:center;">View Docs</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $count = 1;
                            @endphp
                            @if (!empty($data['details']->sale_deed_doc))
                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td>Sale Deed</td>
                                    <td style="text-align:center;"><a
                                            href="{{ asset('storage/' . $data['details']->sale_deed_doc ?? '') }}"
                                            target="_blank" class="text-danger view_docs" data-toggle="tooltip"
                                            title="View Uploaded Files"><i class="bx bxs-file-pdf"></i></a></td>
                                    <td>
                                        <div class="form-check form-check-success">
                                            <input class="form-check-input property-document-approval-chk" type="checkbox"
                                                role="switch" id="saleDeedDoc"
                                                @if ($checkList && $checkList->is_uploaded_doc_checked == 1) checked disabled @endif
                                                @if ($checkList) disabled @endif
                                                @if ($roles === 'deputy-lndo') disabled @endif>
                                            <label class="form-check-label" for="saleDeedDoc">Checked</label>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            @if (!empty($data['details']->lease_deed_doc))
                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td>Lease Deed</td>
                                    <td style="text-align:center;">
                                        <a href="{{ asset('storage/' . $data['details']->lease_deed_doc ?? '') }}"
                                            target="_blank" class="text-danger view_docs" data-toggle="tooltip"
                                            title="View Uploaded Files"><i class="bx bxs-file-pdf"></i></a>
                                    </td>
                                    <td>
                                        <div class="form-check form-check-success">
                                            <input class="form-check-input property-document-approval-chk" type="checkbox"
                                                role="switch" id="leaseDeedDoc"
                                                @if ($checkList && $checkList->is_uploaded_doc_checked == 1) checked disabled @endif
                                                @if ($checkList) disabled @endif
                                                @if ($roles === 'deputy-lndo') disabled @endif>
                                            <label class="form-check-label" for="leaseDeedDoc">Checked</label>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            @if (!empty($data['details']->builder_buyer_agreement_doc))
                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td>Agreement</td>
                                    <td style="text-align:center;"><a
                                            href="{{ asset('storage/' . $data['details']->builder_buyer_agreement_doc ?? '') }}"
                                            target="_blank" class="text-danger view_docs" data-toggle="tooltip"
                                            title="View Uploaded Files"><i class="bx bxs-file-pdf"></i></a></td>
                                    <td>
                                        <div class="form-check form-check-success">
                                            <input class="form-check-input property-document-approval-chk" type="checkbox"
                                                role="switch" id="agreementDoc"
                                                @if ($checkList && $checkList->is_uploaded_doc_checked == 1) checked disabled @endif
                                                @if ($checkList) disabled @endif
                                                @if ($roles === 'deputy-lndo') disabled @endif>
                                            <label class="form-check-label" for="agreementDoc">Checked</label>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            @if (!empty($data['details']->substitution_mutation_letter_doc))
                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td>Substitution/Mutation Letter</td>
                                    <td style="text-align:center;"><a
                                            href="{{ asset('storage/' . $data['details']->substitution_mutation_letter_doc ?? '') }}"
                                            target="_blank" class="text-danger view_docs" data-toggle="tooltip"
                                            title="View Uploaded Files"><i class="bx bxs-file-pdf"></i></a></td>
                                    <td>
                                        <div class="form-check form-check-success">
                                            <input class="form-check-input property-document-approval-chk" type="checkbox"
                                                role="switch" id="subsMutDoc"
                                                @if ($checkList && $checkList->is_uploaded_doc_checked == 1) checked disabled @endif
                                                @if ($checkList) disabled @endif
                                                @if ($roles === 'deputy-lndo') disabled @endif>
                                            <label class="form-check-label" for="subsMutDoc">Checked</label>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            @if (!empty($data['details']->other_doc))
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>Other Document</td>
                                <td style="text-align:center;"><a
                                        href="{{ asset('storage/' . $data['details']->other_doc ?? '') }}"
                                        target="_blank" class="text-danger view_docs" data-toggle="tooltip"
                                        title="View Uploaded Files"><i class="bx bxs-file-pdf"></i></a></td>
                                <td>
                                    <div class="form-check form-check-success">
                                        <input class="form-check-input property-document-approval-chk" type="checkbox"
                                            role="switch" id="ownerLesseeDoc"
                                            @if ($checkList && $checkList->is_uploaded_doc_checked == 1) checked disabled @endif
                                            @if ($checkList) disabled @endif
                                            @if ($roles === 'deputy-lndo') disabled @endif>
                                        <label class="form-check-label" for="ownerLesseeDoc">Checked</label>
                                    </div>
                                </td>
                            </tr>
                        @endif
                            @if (!empty($data['details']->owner_lessee_doc))
                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td>Owner Lessee</td>
                                    <td style="text-align:center;"><a
                                            href="{{ asset('storage/' . $data['details']->owner_lessee_doc ?? '') }}"
                                            target="_blank" class="text-danger view_docs" data-toggle="tooltip"
                                            title="View Uploaded Files"><i class="bx bxs-file-pdf"></i></a></td>
                                    <td>
                                        <div class="form-check form-check-success">
                                            <input class="form-check-input property-document-approval-chk" type="checkbox"
                                                role="switch" id="ownerLesseeDoc"
                                                @if ($checkList && $checkList->is_uploaded_doc_checked == 1) checked disabled @endif
                                                @if ($checkList) disabled @endif
                                                @if ($roles === 'deputy-lndo') disabled @endif>
                                            <label class="form-check-label" for="ownerLesseeDoc">Checked</label>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            @if (!empty($data['details']->authorised_signatory_doc))
                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td>Authorised Signatory</td>
                                    <td><a href="{{ asset('storage/' . $data['details']->authorised_signatory_doc ?? '') }}"
                                            target="_blank" class="text-danger view_docs" data-toggle="tooltip"
                                            title="View Uploaded Files"><i class="bx bxs-file-pdf"></i></a></td>
                                    <td>
                                        <div class="form-check form-check-success">
                                            <input class="form-check-input property-document-approval-chk" type="checkbox"
                                                role="switch" id="subsMutDoc"
                                                @if ($checkList && $checkList->is_uploaded_doc_checked == 1) checked disabled @endif
                                                @if ($checkList) disabled @endif
                                                @if ($roles === 'deputy-lndo') disabled @endif>
                                            <label class="form-check-label" for="subsMutDoc">Checked</label>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            @if (!empty($data['details']->chain_of_ownership_doc))
                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td>Chain Of Ownership</td>
                                    <td><a href="{{ asset('storage/' . $data['details']->chain_of_ownership_doc ?? '') }}"
                                            target="_blank" class="text-danger view_docs" data-toggle="tooltip"
                                            title="View Uploaded Files"><i class="bx bxs-file-pdf"></i></a></td>
                                    <td>
                                        <div class="form-check form-check-success">
                                            <input class="form-check-input property-document-approval-chk" type="checkbox"
                                                role="switch" id="subsMutDoc"
                                                @if ($checkList && $checkList->is_uploaded_doc_checked == 1) checked disabled @endif
                                                @if ($checkList) disabled @endif
                                                @if ($roles === 'deputy-lndo') disabled @endif>
                                            <label class="form-check-label" for="subsMutDoc">Checked</label>
                                        </div>
                                    </td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                </div>
            </div>




            @if ($roles === 'section-officer')

                <div class="part-title mt-2">
                    <h5>OFFICE ACTIVITY</h5>
                </div>
                <div class="part-details">
                    <form id="approvalForm" method="POST" action="{{ route('approve.applicant.new.property') }}">
                        @csrf

                        <div class="container-fluid pb-3">
                            <div class="row">
                                <input type="hidden" name="newlyAddedPropertyId" id="newlyAddedPropertyId"
                                    value="{{ $data['details']->id ?? '' }}">
                                <input type="hidden" name="oldPropertyId" id="oldPropertyId"
                                    value="{{ $data['oldPropertyId'] ?? '' }}">

                                <div class="col-lg-12">
                                    <h4 class="suggestedpropertytitle">Property Details</h4>
                                </div>
                                <div class="col-lg-9">
                                    
                                    @if ($data['suggestedPropertyId'])
                                    <input type="hidden" name="suggestedPropertyId" class="form-control"
                                                id="SuggestedPropertyID" placeholder="Suggested Property ID"
                                                value="{{ $data['suggestedPropertyId'] ?? '' }}" readonly>
                                        <!-- <div class="w-25">
                                            <div class="d-flex justify-space-between items-end">
                                                <label for="PropertyID" class="form-label">Suggested Property ID</label>
                                                <a href="javascript:void(0);" id="PropertyIDSearchBtn"
                                                    class="pl-2 pr-4 fs-2 text-decoration-none d-flex flex-column align-items-center justify-content-end"
                                                    data-toggle="tooltip" title="View Scanned Files"
                                                    data-bs-toggle="modal" data-bs-target="#viewScannedFiles">
                                                    <i class='bx bxs-file-pdf text-danger'></i>
                                                </a>
                                            </div>
                                            <input type="text" name="suggestedPropertyId" class="form-control"
                                                id="SuggestedPropertyID" placeholder="Suggested Property ID"
                                                value="{{ $data['suggestedPropertyId'] ?? '' }}" readonly>
                                        </div> -->
                                        <table class="table table-bordered property-table-infos mb-0 verticle-middle">
                                            <tr>
                                                <td><strong>Suggested Property ID:</strong> 43345</td>
                                                <td><strong>Block:</strong> SADARPUR</td>
                                                <td><strong>Plot:</strong> A/24</td>
                                                <td><strong>Property/Files No:</strong> 78348</td>
                                                <td class="inline-icon"><strong>Scanned Files:</strong> <a href="javascript:void(0);" id="PropertyIDSearchBtn"
                                                    class="pl-2 pr-4 fs-2 text-decoration-none d-flex flex-column align-items-center justify-content-end"
                                                    data-toggle="tooltip" title="View Scanned Files"
                                                    data-bs-toggle="modal" data-bs-target="#viewScannedFiles">
                                                    <i class='bx bxs-file-pdf text-danger'></i>
                                                </a></td>
                                            </tr>
                                        </table>
                                        
                                </div>
                                <div class="col-lg-3 col-12">
                                    <div class="btn-end">
                                        <div class="btn-group">
                                            <a
                                                href="{{ route('viewDetails', ['property' => $data['propertyMasterId']]) }}">
                                                <button type="button" id="PropertyIDSearchBtn"
                                                    class="btn btn-primary ml-2">Go to Details</button>
                                            </a>
                                        </div>
                                      
                                @endif

                                <div class="btn-group">
                                    <a href="{{ route('mis.index') }}">
                                        <button type="button" id="PropertyIDSearchBtn"
                                            class="btn btn-warning ml-2">Go to MIS</button>
                                    </a>
                                </div>
                            </div>
                                </div>
                                @if ($data['details']->status !== getStatusName('RS_REJ'))
                                    @if ($data['details']->status !== getStatusName('RS_APP'))
                                        <div class="row pt-3">
                                            <div class="col-lg-12 mt-4">
                                                <div class="checkbox-options">
                                                    <div class="form-check form-check-success">
                                                        <label class="form-check-label" for="isUnderReview">
                                                            Send To Deputy L&DO For Review
                                                        </label>
                                                        <input class="form-check-inputs" type="checkbox" value="review"
                                                            id="isUnderReview"
                                                            @if ($data['details']->status == getStatusName('RS_UREW')) checked disabled @endif>
                                                        <div class="text-danger required-error-message">This field is
                                                            required.</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                                <div class="row py-3">
                                    <div class="col-lg-4 mt-4">
                                        <div class="checkbox-options">
                                            <div class="form-check form-check-success">
                                                <label class="form-check-label" for="isMISCorrect">
                                                    is MIS Checked
                                                </label>
                                                <input class="form-check-input required-for-approve"
                                                    @if ($checkList && $checkList->is_mis_checked == 1) checked disabled @endif
                                                    @if ($checkList) disabled @endif
                                                    name="is_mis_checked" type="checkbox" value="1"
                                                    id="isMISCorrect">
                                                <div class="text-danger required-error-message">This field is required.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mt-4">
                                        <div class="checkbox-options">
                                            <div class="form-check form-check-success">
                                                <label class="form-check-label" for="isScanningCorrect">
                                                    is Property Scanned File Checked
                                                </label>
                                                <input class="form-check-input required-for-approve"
                                                    @if ($checkList && $checkList->is_scan_file_checked == 1) checked disabled @endif
                                                    @if ($checkList) disabled @endif
                                                    name="is_scan_file_checked" type="checkbox" value="1"
                                                    id="isScanningCorrect">
                                                <div class="text-danger required-error-message">This field is required.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mt-4">
                                        <div class="checkbox-options">
                                            <div class="form-check form-check-success">
                                                <label class="form-check-label" for="isDocumentCorrect">
                                                    is Uploaded Documents Checked
                                                </label>
                                                <input class="form-check-input required-for-approve"
                                                    @if ($checkList && $checkList->is_uploaded_doc_checked == 1) checked disabled @endif
                                                    @if ($checkList) disabled @endif
                                                    name="is_uploaded_doc_checked" type="checkbox" value="1"
                                                    id="isDocumentCorrect">
                                                <div class="text-danger required-error-message"
                                                    id="isDocumentCorrectError">
                                                    This field is required.
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>

                        @if (
                            $data['details']->status == getStatusName('RS_REW') ||
                                $data['details']->status == getStatusName('RS_NEW') ||
                                $data['details']->status == getStatusName('RS_PEN'))
                            <div class="row">
                                <div class="d-flex gap-4 col-lg-12">
                                    <button type="button" class="btn btn-primary" id="approveBtn">Approve</button>
                                    @if (Auth::user()->hasRole('section-officer') && Auth::user()->can('reject.register.user'))
                                        <button type="button" id="rejectButton" class="btn btn-danger">Reject</button>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </form>
                </div>

            @endif
            @if ($roles === 'deputy-lndo')

                <div class="part-title mt-2">
                    <h5>OFFICE ACTIVITY</h5>
                </div>
                <div class="part-details">
                    <form id="approvalForm" method="POST"
                        action="{{ route('approve.review.applicant.new.property') }}">
                        @csrf
                        <div class="container-fluid pb-3">
                            <div class="row">
                                <input type="hidden" name="applicationMovementId" id="applicationMovementId"
                                    value="{{ $data['applicationMovementId'] ?? '' }}">
                                <div class="d-flex gap-1 flex-row align-items-end ">
                                    @if ($data['suggestedPropertyId'])
                                        <div class="w-25">
                                            <div class="d-flex justify-space-between items-end">
                                                <label for="PropertyID" class="form-label">Suggested Property ID</label>
                                                <a href="javascript:void(0);" id="PropertyIDSearchBtn"
                                                    class="pl-2 pr-4 fs-2 text-decoration-none d-flex flex-column align-items-center justify-content-end"
                                                    data-toggle="tooltip" title="View Scanned Files"
                                                    data-bs-toggle="modal" data-bs-target="#viewScannedFiles">
                                                    <i class='bx bxs-file-pdf text-danger'></i>
                                                </a>
                                            </div>
                                            <input type="text" name="suggestedPropertyId" class="form-control"
                                                id="SuggestedPropertyID" placeholder="Suggested Property ID"
                                                value="{{ $data['suggestedPropertyId'] ?? '' }}" readonly>
                                        </div>

                                        <div class="btn-group">
                                            <a
                                                href="{{ route('viewDetails', ['property' => $data['propertyMasterId']]) }}">
                                                <button type="button" id="PropertyIDSearchBtn"
                                                    class="btn btn-primary ml-2">Go to Details</button>
                                            </a>
                                        </div>
                                    @endif

                                    <div class="btn-group">
                                        <a href="{{ route('mis.index') }}">
                                            <button type="button" id="PropertyIDSearchBtn"
                                                class="btn btn-warning ml-2">Go
                                                to MIS</button>
                                        </a>
                                    </div>
                                </div>
                                @if ($data['details']->status == getStatusName('RS_APP') || $data['details']->status == getStatusName('RS_REW'))
                                @else
                                    <div class="row">
                                        <div class="col-lg-12 mt-4">
                                            <label for="remarks" class="form-label">Enter Remark</label>
                                            <textarea id="remarks" name="remarks" placeholder="Enter Remarks" class="form-control" rows="6"></textarea>
                                            <div class="text-danger" id="errorMsgNew">Remark is required.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 mt-4" style="text-align: right;">
                                            <button type="button" class="btn btn-primary" id="reviewBtnNew"
                                                disabled>Reviewed</button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
        </div>
    </div>
    @endif

    <!-- View Scanned Files Modal -->
    <div class="modal fade" id="viewScannedFiles" data-backdrop="static" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewScannedFilesLabel">View Scanned Files</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="files-link">
                        <li><a href="#" target="_blank">Sale-Dead-15-07-2018.pdf</a></li>
                        <li><a href="#" target="_blank">Lease-Dead-15-07-2018.pdf</a></li>
                        <li><a href="#" target="_blank">Agreement-Dead-15-07-2018.pdf</a></li>
                        <li><a href="#" target="_blank">Sustitution-Mutation-Letter-15-07-2018.pdf</a></li>
                    </ul>
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- End Modal -->
    @include('include.alerts.applicant-new-property-confirmation')
@endsection
@section('footerScript')
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            //Reject the application
            $('#rejectButton').click(function() {
                var isDocumentCorrect = $('#isDocumentCorrect');
                if (isDocumentCorrect.is(':checked')) {
                    $('#isDocumentCorrectError').hide();
                    var value1 = 0;
                    var input1 = $('#isMISCorrect');
                    if (input1.is(':checked')) {
                        value1 = 1;
                    }
                    var value2 = 0;
                    var input2 = $('#isScanningCorrect');
                    if (input2.is(':checked')) {
                        value2 = 1;
                    }

                    var value3 = 0;
                    var input3 = $('#isDocumentCorrect');
                    if (input3.is(':checked')) {
                        value3 = 1;
                    }

                    // Dynamically create input elements and append to the modal
                    $('#modalInputs').html(`
                    <input type="hidden" id="input1" name="is_mis_checked" value="${value1}">
                    <input type="hidden" id="input2" name="is_scan_file_checked" value="${value2}">
                    <input type="hidden" id="input3" name="is_uploaded_doc_checked" value="${value3}">
                    <br>
                    `);

                    $('#rejecNewPropertyStatus').modal('show');
                } else {
                    $('#isDocumentCorrectError').show();
                }
            })





            $('#approveBtn').click(function() {
                let allChecked = true;
                $('.required-for-approve').each(function() {
                    const $checkbox = $(this);
                    // console.log($checkbox);
                    const $errorMsg = $checkbox.siblings('.required-error-message');
                    // console.log($errorMsg);
                    if (!$checkbox.is(':checked')) {
                        console.log('inside if');
                        $errorMsg.show();
                        allChecked = false;
                    } else {
                        console.log('inside else');
                        $errorMsg.hide();
                    }
                });
                if (allChecked) {
                    //Check Property link with other applicant.
                    var button = $('#approveBtn');
                    var error = $('#isPropertyFree');
                    button.prop('disabled', true);
                    button.html('Submitting...');
                    var propertyId = $('#SuggestedPropertyID').val();
                    $.ajax({
                        url: "{{ route('register.user.checkProperty', ['id' => '__propertyId__']) }}"
                            .replace('__propertyId__', propertyId),
                        type: "POST",
                        dataType: "JSON",
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            console.log(response);
                            if (response.success === true) {
                                $('#approvePropertyModal').modal('show');
                            } else {
                                $('#checkProperty').modal('show');
                                error.html(response.details)
                                button.prop('disabled', false);
                                button.html('Approve');
                            }
                        },
                        error: function(response) {
                            console.log(response);
                        }
                    });
                    // $('#approvePropertyModal').modal('show');
                    // $('#approveBtn').prop('disabled', true);
                    // $('#approveBtn').html('Submitting...');
                    // $('#approvalForm').submit();
                }
            });

            $('#confirmApproveSubmit').on('click', function(e) {
                e.preventDefault();
                $('#approveBtn').prop('disabled', true);
                $('#approveBtn').html('Submitting...');
                $('#approvalForm').submit();
            });




            $('#rejectBtn').on('click', function(e) {
                e.preventDefault();
                $('#rejectModal').modal('show');
            });
        });

        $(document).ready(function() {
            $('#isUnderReview').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#modelReview').modal('show');
                }
            });

            // Optionally, you can handle the closing of the modal
            $('#modelReview').on('hidden.bs.modal', function() {
                // Do something after the modal is hidden, like unchecking the checkbox if needed
                $('#isUnderReview').prop('checked', false);
            });
        });

        // Event delegation for dynamically added elements by lalit on 01/08-2024 for remarks validation
        $(document).on('click', '.confirm-reject-btn', function(event) {
            event.preventDefault();

            var form = $(this).closest('form');
            var remarksInput = form.find('input[name="remarks"]');
            // var remarksValue = remarksInput.val().trim();
            var remarksValue = remarksInput.val();
            var errorLabel = form.find('.error-label');

            if (remarksValue === '') {
                // Show the error label if remarks are empty
                if (errorLabel.length === 0) {
                    // If the error label doesn't exist, create it
                    form.find('.input-class-reject').append(
                        '<div class="error-label text-danger mt-2">Please enter remarks for rejection.</div>');
                } else {
                    // If the error label exists, just show it
                    errorLabel.show();
                }
            } else {
                // Hide the error label and submit the form
                if (errorLabel.length > 0) {
                    errorLabel.hide();
                }
                form.submit();
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var remarksTextarea = document.getElementById('remarks');
            if (remarksTextarea) {
                var $reviewBtnNew = $('#reviewBtnNew');
                // Event listener for keypress event
                remarksTextarea.addEventListener('keypress', function(event) {
                    // You can perform actions here based on the key pressed
                    $reviewBtnNew.prop('disabled', false); // Enable button
                });
            }
        });

        $(document).ready(function() {
            var $errorMsg = $('#errorMsgNew');

            $('#reviewBtnNew').click(function() {
                var allChecked = true;
                var remark = $('#remarks').val();

                if (remark.trim() === '') {
                    $errorMsg.show();
                    allChecked = false;
                } else {

                    $errorMsg.hide();
                    allChecked = true;
                }

                if (allChecked) {
                    $('#reviewBtnNew').prop('disabled', true);
                    $('#reviewBtnNew').html('Submitting...');
                    $('#approvalForm').submit();
                }
            });
        });

        /*$(document).ready(function() {
            // When the checkbox with name "is_uploaded_doc_checked" is checked or unchecked
            $('input[name="is_uploaded_doc_checked"]').change(function() {
                // Check or uncheck all checkboxes with the class "property-document-approval-chk"
                $('.property-document-approval-chk').prop('checked', $(this).prop('checked'));
            });

            // When any checkbox with the class "property-document-approval-chk" is checked or unchecked
            $('.property-document-approval-chk').change(function() {
                // Check if all checkboxes with class "property-document-approval-chk" are checked
                var allChecked = $('.property-document-approval-chk').length === $(
                    '.property-document-approval-chk:checked').length;

                // Check or uncheck the checkbox with name "is_uploaded_doc_checked"
                $('input[name="is_uploaded_doc_checked"]').prop('checked', allChecked);
            });
        });*/

        $(document).ready(function() {
            // When the checkbox with name "is_uploaded_doc_checked" is checked or unchecked
            $('input[name="is_uploaded_doc_checked"]').change(function() {

                // Check if any checkbox with class "property-document-approval-chk" is unchecked
                if ($(this).prop('checked') && $('.property-document-approval-chk:not(:checked)').length >
                    0) {
                    // Show error message
                    $('#isDocumentCorrectError').text('');
                    $('#isDocumentCorrectError').text('Please check the uploaded documents.').show();
                    $(this).prop('checked', false); // Uncheck the checkbox
                } else {
                    // Hide error message
                    $('#isDocumentCorrectError').hide();
                }
            });

            // When any checkbox with the class "property-document-approval-chk" is checked or unchecked
            $('.property-document-approval-chk').change(function() {
                // Check if all checkboxes with class "property-document-approval-chk" are checked
                var allChecked = $('.property-document-approval-chk').length === $(
                    '.property-document-approval-chk:checked').length;

                // Check or uncheck the checkbox with name "is_uploaded_doc_checked"
                $('input[name="is_uploaded_doc_checked"]').prop('checked', allChecked);

                // Hide error message if all checkboxes are checked
                if (allChecked) {
                    $('#isDocumentCorrectError').hide();
                }
            });
        });
    </script>

@endsection
