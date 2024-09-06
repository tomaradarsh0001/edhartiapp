@extends('layouts.app')

@section('title', 'User Registration Details')

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
    </style>
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">APPLICATION</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">User Details</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- <div class="ms-auto"><a href="#" class="btn btn-primary">Button</a></div> -->

    <hr>

    <div class="card">
        <div class="card-body pb-5">

            <div class="container-fluid">
                <h5 class="mb-4 pt-3 text-decoration-underline">USER DETAILS</h5>
                <div class="container-fluid pb-3">
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <ul class="basic-user-details">
                                <li><strong>Registration ID: </strong> {{ $data['details']->applicant_number ?? '' }}
                                </li>
                                <li><strong>Name: </strong> {{ $data['details']->name ?? '' }}</li>
                                <li><strong>Email: </strong> {{ $data['details']->email ?? '' }}</li>
                                <li><strong>Mobile: </strong> {{ $data['details']->mobile ?? '' }}</li>
                                <li><strong>Gender: </strong> {{ $data['details']->gender ?? '' }}</li>
                                <li><strong>S/o, D/0, Spouse: </strong>{{ $data['details']->second_name ?? '' }}</li>

                            </ul>
                        </div>
                        <div class="col-lg-6 col-12">
                            <ul class="basic-user-details">
                                <li class="text-capitalize"><strong>Current Status: </strong>
                                    @switch(getStatusDetailsById( $data['details']->status ?? '' )->item_code)
                                        @case('RS_REJ')
                                            <div
                                                class="ml-2 badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3">
                                                {{ getStatusDetailsById($data['details']->status ?? '')->item_name }}
                                            </div>
                                        @break

                                        @case('RS_NEW')
                                            <div
                                                class="ml-2 badge rounded-pill text-primary bg-light-primary p-2 text-uppercase px-3">
                                                {{ getStatusDetailsById($data['details']->status ?? '')->item_name }}
                                            </div>
                                        @break

                                        @case('RS_UREW')
                                            <div class="ml-2 badge rounded-pill  text-warning bg-light-warning p-2 text-uppercase px-3">
                                                {{ getStatusDetailsById($data['details']->status ?? '')->item_name }}
                                            </div>
                                        @break

                                        @case('RS_REW')
                                            <div
                                                class="ml-2 badge rounded-pill text-white bg-secondary p-2 text-uppercase px-3">
                                                {{ getStatusDetailsById($data['details']->status ?? '')->item_name }}
                                            </div>
                                        @break

                                        @case('RS_PEN')
                                            <div class="ml-2 badge rounded-pill text-info bg-light-info p-2 text-uppercase px-3">
                                                {{ getStatusDetailsById($data['details']->status ?? '')->item_name }}
                                            </div>
                                        @break

                                        @case('RS_APP')
                                            <div
                                                class="ml-2 badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3">
                                                {{ getStatusDetailsById($data['details']->status ?? '')->item_name }}
                                            </div>
                                        @break

                                        @default
                                            <div class="ml-2 badge rounded-pill text-secondary bg-light p-2 text-uppercase px-3">
                                                {{ getStatusDetailsById($data['details']->status ?? '')->item_name }}
                                            </div>
                                    @endswitch
                                </li>
                                <li><strong>Registration Type: </strong> {{ $data['details']->user_type ?? '' }}</li>
                                <li><strong>PAN: </strong> {{ $data['details']->pan_number ?? '' }}</li>
                                <li><strong>Aadhar: </strong>{{ $data['details']->aadhar_number ?? '' }}</li>
                                <li><strong>Address: </strong> {{ $data['details']->comm_address ?? '' }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                @if (!empty($data['details']->organization_name))
                    <h5 class="mb-4 pt-3 text-decoration-underline">ORGANIZATION DETAILS</h5>
                    <div class="container-fluid pb-3">
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <ul class="basic-user-details">
                                    <li><strong>Organization Name: </strong>
                                        {{ $data['details']->organization_name ?? '' }}
                                    </li>
                                    <li><strong>Organization PAN: </strong>
                                        {{ $data['details']->organization_pan_card ?? '' }}</li>
                                </ul>
                            </div>
                            <div class="col-lg-6 col-12">
                                <ul class="basic-user-details">
                                    <li><strong>Organization Address:
                                        </strong>{{ $data['details']->organization_address ?? '' }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <hr>
                @endif

                <h5 class="mb-4 pt-3 text-decoration-underline">PROPERTY DOCUMENT DETAILS</h5>
                <div class="container-fluid pb-3">
                    <table class="table table-bordered table-striped property-table-info">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Document Name</th>
                                <th>View Docs</th>
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
                                    <td><a href="{{ $data['details']->sale_deed_doc ?? '' }}" target="_blank"
                                            class="text-primary view_docs" data-toggle="tooltip"
                                            title="View Uploaded Files"><i class="bx bxs-file-pdf text-danger"></i></a></td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="saleDeedDoc">
                                            <label class="form-check-label" for="saleDeedDoc">Not Approved/Approved</label>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            @if (!empty($data['details']->lease_deed_doc))
                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td>Lease Deed</td>
                                    <td>
                                        <a href="{{ $data['details']->lease_deed_doc ?? '' }}" target="_blank" class="text-primary view_docs" data-toggle="tooltip" title="View Uploaded Files"><i class="bx bxs-file-pdf text-danger"></i></a></td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                id="leaseDeedDoc">
                                            <label class="form-check-label" for="leaseDeedDoc">Not Approved/Approved</label>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            @if (!empty($data['details']->builder_buyer_agreement_doc))
                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td>Agreement</td>
                                    <td><a href="{{ $data['details']->builder_buyer_agreement_doc ?? '' }}" target="_blank"
                                            class="text-primary view_docs" data-toggle="tooltip"
                                            title="View Uploaded Files"><i class="bx bxs-file-pdf text-danger"></i></a></td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                id="agreementDoc">
                                            <label class="form-check-label" for="agreementDoc">Not Approved/Approved</label>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            @if (!empty($data['details']->substitution_mutation_letter_doc))
                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td>Substitution/Mutation Letter</td>
                                    <td><a href="{{ $data['details']->substitution_mutation_letter_doc ?? '' }}"
                                            target="_blank" class="text-primary view_docs" data-toggle="tooltip"
                                            title="View Uploaded Files"><i class="bx bxs-file-pdf text-danger"></i></a></td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="subsMutDoc">
                                            <label class="form-check-label" for="subsMutDoc">Not Approved/Approved</label>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            @if (!empty($data['details']->owner_lessee_doc))
                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td>Owner Lessee</td>
                                    <td><a href="{{ $data['details']->owner_lessee_doc ?? '' }}" target="_blank"
                                            class="text-primary view_docs" data-toggle="tooltip"
                                            title="View Uploaded Files"><i class="bx bxs-file-pdf text-danger"></i></a></td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                id="subsMutDoc">
                                            <label class="form-check-label" for="subsMutDoc">Not Approved/Approved</label>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            @if (!empty($data['details']->authorised_signatory_doc))
                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td>Authorised Signatory</td>
                                    <td><a href="{{ $data['details']->authorised_signatory_doc ?? '' }}" target="_blank"
                                            class="text-primary view_docs" data-toggle="tooltip"
                                            title="View Uploaded Files"><i class="bx bxs-file-pdf text-danger"></i></a></td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                id="subsMutDoc">
                                            <label class="form-check-label" for="subsMutDoc">Not Approved/Approved</label>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            @if (!empty($data['details']->chain_of_ownership_doc))
                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td>Chain Of Ownership</td>
                                    <td><a href="{{ $data['details']->chain_of_ownership_doc ?? '' }}" target="_blank"
                                            class="text-primary view_docs" data-toggle="tooltip"
                                            title="View Uploaded Files"><i class="bx bxs-file-pdf text-danger"></i></a></td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                id="subsMutDoc">
                                            <label class="form-check-label" for="subsMutDoc">Not Approved/Approved</label>
                                        </div>
                                    </td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                </div>
                <hr>

                @if ($roles === 'section-officer')
                    <form id="approvalForm" method="POST" action="{{ route('approve.user.registration') }}">
                        @csrf
                        <h5 class="mb-4 pt-3 text-decoration-underline">OFFICE ACTIVITY</h5>
                        <div class="container-fluid pb-3">
                            <div class="row">
                                <input type="hidden" name="emailId" id="emailId"
                                    value="{{ $data['details']->email ?? '' }}">
                                <input type="hidden" name="registrationId" id="registrationId"
                                    value="{{ $data['details']->id ?? '' }}">
                                <input type="hidden" name="oldPropertyId" id="oldPropertyId"
                                    value="{{ $data['oldPropertyId'] ?? '' }}">


                                <div class="d-flex gap-3 flex-row align-items-end ">
                                    @if ($data['suggestedPropertyId'])
                                        <div class="w-25">
                                            <div class="d-flex flex-row-reverse justify-content-between align-items-end">
                                                <a href="javascript:void(0);" id="PropertyIDSearchBtn"
                                                    class="pl-2 pr-4 fs-2 text-decoration-none d-flex flex-column align-items-center justify-content-end"
                                                    data-toggle="tooltip" title="View Scanned Files" data-bs-toggle="modal"
                                                    data-bs-target="#viewScannedFiles">
                                                    <i class='bx bxs-file-pdf text-danger'></i>
                                                </a>
                                                    <label for="PropertyID" class="form-label">Suggested Property ID</label>
                                            </div>
                                            <input type="text" name="suggestedPropertyId" class="form-control"
                                                id="SuggestedPropertyID" placeholder="Suggested Property ID"
                                                value="{{ $data['suggestedPropertyId'] ?? '' }}" readonly>
                                        </div>
                                        <div class="btn-group">
                                            <a
                                                href="{{ route('viewDetails', ['property' => $data['suggestedPropertyId']]) }}">
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
                                                    <input class="form-check-input" @if ($checkList && $checkList->is_mis_checked == 1) checked disabled @endif @if ($checkList) disabled @endif name="is_mis_checked" type="checkbox" value="1"
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
                                                    <input class="form-check-input"  @if ($checkList && $checkList->is_scan_file_checked == 1) checked disabled @endif  @if ($checkList) disabled @endif name="is_scan_file_checked" type="checkbox" value="1"
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
                                                    <input class="form-check-input"  @if ($checkList && $checkList->is_uploaded_doc_checked == 1) checked disabled @endif  @if ($checkList) disabled @endif  name="is_uploaded_doc_checked" type="checkbox" value="1"
                                                        id="isDocumentCorrect">
                                                    <div class="text-danger required-error-message"
                                                        id="isDocumentCorrectError">This field is required.
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                

                            </div>
                        </div>

                        @if ($data['details']->status == getStatusName('RS_REW') || $data['details']->status == getStatusName('RS_NEW'))
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
                @endif
                @if ($roles === 'deputy-lndo')
                    <form id="approvalForm" method="POST" action="{{ route('approve.review.application') }}">
                        @csrf
                        <div class="container-fluid pb-3">
                            <div class="row">
                                <input type="hidden" name="applicationMovementId" id="applicationMovementId"
                                    value="{{ $data['applicationMovementId'] ?? '' }}">
                                <div class="d-flex flex-row align-items-end gap-3">
                                    @if ($data['suggestedPropertyId'])
                                        <div class="w-25">
                                            <div class="d-flex flex-row-reverse justify-content-between align-items-end">
                                                <a href="javascript:void(0);" id="PropertyIDSearchBtn"
                                                    class="pl-2 pr-4 fs-2 text-decoration-none d-flex flex-column align-items-center justify-content-end"
                                                    data-toggle="tooltip" title="View Scanned Files" data-bs-toggle="modal"
                                                    data-bs-target="#viewScannedFiles">
                                                    <i class='bx bxs-file-pdf text-danger'></i>
                                                </a>
                                                    <label for="PropertyID" class="form-label">Suggested Property ID</label>
                                            </div>
                                            <input type="text" name="suggestedPropertyId" class="form-control"
                                                id="SuggestedPropertyID" placeholder="Suggested Property ID"
                                                value="{{ $data['suggestedPropertyId'] ?? '' }}" readonly>
                                        </div>
                                    @endif
                                    @if ($data['suggestedPropertyId'])
                                        <div class="btn-group">
                                            <a
                                                href="{{ route('viewDetails', ['property' => $data['suggestedPropertyId']]) }}">
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
                @endif


            </div>
        </div>
    </div>
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
    <!-- End Modal -->
    @include('include.alerts.reject-user-registration-confirmation')

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

                    $('#rejectUserStatus').modal('show');
                } else {
                    $('#isDocumentCorrectError').show();
                }
            })





            $('#approveBtn').click(function() {
                let allChecked = true;
                $('.form-check-input').each(function() {
                    const $checkbox = $(this);
                    const $errorMsg = $checkbox.siblings('.required-error-message');
                    if (!$checkbox.is(':checked')) {
                        $errorMsg.show();
                        allChecked = false;
                    } else {
                        $errorMsg.hide();
                        allChecked = true;
                    }
                });
                if (allChecked) {
                    // All checkboxes are checked (is MIS Correct, is Property Scanned File Available, is Uploaded Documents Correct), then only submit the form
                    $('#approveBtn').prop('disabled', true);
                    $('#approveBtn').html('Submitting...');
                    $('#approvalForm').submit();
                }
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
    </script>

@endsection
