@extends('layouts.app')

@section('title', 'Register User Listing')

@section('content')

    <style>
        div.dt-buttons {
            float: none !important;
            width: 19%;
        }

        div.dt-buttons.btn-group {
            margin-bottom: 20px;
        }

        div.dt-buttons.btn-group .btn {
            font-size: 12px;
            padding: 5px 10px;
            border-radius: 4px;
        }

        /* Ensure responsiveness on smaller screens */
        @media (max-width: 768px) {
            div.dt-buttons.btn-group {
                flex-direction: column;
                align-items: flex-start;
            }

            div.dt-buttons.btn-group .btn {
                width: 100%;
                text-align: left;
            }
        }
    </style>
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Registrations</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Registration Applications List</li>
                </ol>
            </nav>
        </div>
        <!-- <div class="ms-auto"><a href="#" class="btn btn-primary">Button</a></div> -->
    </div>

    <hr>

    <div class="card">
        <div class="card-body">
            <table id="example" class="display nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Applicant Number</th>
                        <th>Name</th>
                        <th>Property Details</th>
                        <th>Registration Type</th>
                        <th>Purpose Of Registration</th>
                        <th>Document</th>
                        <th><select class="form-control form-select form-select-sm" name="status" id="status"
                                style="font-weight: bold;">
                                <option value="">Status</option>
                                @foreach ($items as $item)
                                    <option class="text-capitalize" value="{{ $item->id }}">{{ $item->item_name }}
                                    </option>
                                @endforeach
                            </select></th>
                        <th>Remark</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>

        </div>
    </div>
    <div id="tooltip"></div>
@endsection


@section('footerScript')

    <script type="text/javascript">
        $(document).ready(function() {
            $('#example').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('get.registered.users') }}",
                    data: function(d) {
                        d.status = $('#status').val(); // Add selected status to the request
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'applicant_number',
                        name: 'applicant_number'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'property_details',
                        name: 'property_details'
                    },
                    {
                        data: 'user_type',
                        name: 'user_type'
                    },
                    {
                        data: 'purpose_of_registation',
                        name: 'purpose_of_registation'
                    },
                    {
                        data: 'documents',
                        name: 'documents',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            let documentLinks = '';
                            $.each(data, function(key, doc) {
                                if (doc) {
                                    let docParts = doc.split('/');
                                    let docName = docParts[docParts.length - 1];
                                    let docUrl = "{{ asset('storage/') }}/" + doc;
                                    documentLinks +=
                                        "<span><i class='bx bx-chevron-right'></i> " +
                                        "<a href='" + docUrl +
                                        "' target='_blank' class='link-primary'>" +
                                        docName + "</a></span><br>";
                                }
                            });

                            // Return the HTML for the document links with a tooltip
                            return '<a href="javascript:void(0);" class="text-danger pdf-icons" data-bs-toggle="tooltip" data-bs-html="true"><i class="bx bxs-file-pdf fs-4"></i></a><div class="tooltip-data">' +
                                documentLinks + '</div>';
                        }
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'remark',
                        name: 'remark',
                        render: function(data, type, row) {
                            let escapedData = $('<div>').text(data.remark).html();
                            escapedData += $('<span>').text(' (' + data.assigned_by_name + ')')
                                .css({
                                    'font-size': '13px',
                                    'color': '#7e7e7ea1',
                                    'font-weight': '700'
                                }).html();

                            let shortRemark = escapedData.length > 30 ? escapedData.substring(0,
                                30) + '...' : escapedData;

                            return `<div class="text-wrap custom-tooltip" data-bs-toggle="tooltip" data-bs-html="true" title="${escapedData}">${shortRemark}</div>`;
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                    }
                ],
                dom: '<"top"Blf>rt<"bottom"ip><"clear">', // Custom DOM for button and pagination positioning
                buttons: [
                    'csv', 'excel', {
                        extend: 'pdf',
                        exportOptions: {
                            columns: ':not(:nth-child(7))', // Exclude the 7th column (documents)
                            format: {
                                header: function(data, columnIdx) {
                                    if (columnIdx === 7) {
                                        // For the status column, return only "Status" in the export
                                        return 'Status';
                                    }
                                    return data; // return original header for other columns
                                }
                            }
                        }
                    }
                ],
                // buttons: [{
                //         extend: 'csv',
                //         exportOptions: {
                //             columns: ':not(:nth-child(7))' // Exclude the 7th column (documents)
                //         }
                //     },
                //     {
                //         extend: 'excel',
                //         exportOptions: {
                //             columns: ':not(:nth-child(7))' // Exclude the 7th column (documents)
                //         }
                //     },
                //     {
                //         extend: 'pdf',
                //         exportOptions: {
                //             columns: ':not(:nth-child(7))' // Exclude the 7th column (documents)
                //         }
                //     }
                // ],
                // responsive: true, // Responsive design enabled
                createdRow: function(row, data, dataIndex) {
                    // Apply classes to the specific column (assuming documents is the 6th column)
                    $('td', row).eq(6).addClass('view-hover-data show-toggle-data');
                },
                drawCallback: function(settings) {
                    // Initialize tooltips
                    $('[data-bs-toggle="tooltip"]').tooltip();
                }
            });
            // Trigger table reload on status filter change
            $('#status').change(function() {
                table.ajax.reload();
            });
        });
    </script>
@endsection
