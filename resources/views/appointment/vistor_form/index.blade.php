@extends('layouts.app')
@section('title', 'Appointments List')

@section('content')

<style>
    .btn-group {
        gap: 0 !important;
        border-radius: 0.375rem !important;
    }

    .btn-group,
    .btn-group-vertical {
        position: relative !important;
        display: inline-flex !important;
        vertical-align: middle !important;
        margin-bottom: 25px !important;
    }

    /* Custom style for validation messages */
    .validation-error {
        color: red;
        font-size: 0.875em;
        display: none; /* Hidden by default */
    }
</style>

<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Section Dashboard</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">Appointment List</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive m-3">
            <table class="table table-striped table-bordered" id="myDataTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Meeting Purpose</th>
                        <th>Meeting Date & Time</th>
                        <th>
                            <form method="GET" action="{{ route('appointments.index') }}" class="form-inline">
                                <div class="input-group" style="margin-top:10px;">
                                    <select class="form-select" id="statusSelect" name="status" onchange="this.form.submit()" style="width: 20px; margin-left:5px;">
                                        <option value="">All</option>
                                        <option value="Approved" @if($status == 'Approved') selected @endif>Approved</option>
                                        <option value="Completed" @if($status == 'Completed') selected @endif>Completed</option>
                                        <option value="Rejected" @if($status == 'Rejected') selected @endif>Rejected</option>
                                    </select>
                                </div>
                            </form>
                        </th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($appointments as $appointment)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $appointment->unique_id }}</td>
                            <td>{{ $appointment->name }}</td>
                            <td>
                                {{ implode('/', array_filter([$appointment->locality, $appointment->block, $appointment->plot])) }} <br> ({{ $appointment->known_as }})
                            </td>
                            <td><b>{{ $appointment->meeting_purpose }}</b> <br> 
                                {{$appointment->meeting_description }}</td>
                            <td>
                                <i class='bx bx-calendar'></i> {{ $appointment->meeting_date->format('Y-m-d') }}<br>
                                <i class='bx bx-time-five' style="color: blue;"></i> 
                                <span style="font-size: 0.875em; color: blue;">
                                    {{ $appointment->meeting_timeslot }}
                                    @if($appointment->nature_of_visit == 'Online')
                                        <i class="bx bxs-circle me-1" style="color: green;"></i>
                                    @else
                                        <i class="bx bxs-circle me-1" style="color: red;"></i>
                                    @endif
                                </span>
                            </td>
                            <td id="status-{{ $appointment->id }}">
                                @if($appointment->status == 'Approved')
                                    <span class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3">{{ $appointment->status }}</span>
                                @elseif($appointment->status == 'Rejected')
                                    <span class="badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3">{{ $appointment->status }}</span>
                                @elseif($appointment->status == 'Completed')
                                    <span class="badge rounded-pill text-info bg-light-info p-2 text-uppercase px-3">{{ $appointment->status }}</span>
                                @endif
                            </td>
                            <td id="action-{{ $appointment->id }}">
                                @if($appointment->status == 'Approved')
                                    <button class="btn btn-danger btn-sm" onclick="openRejectConfirmationModal('{{ $appointment->id }}')">Reject</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>       
</div>

@include('include.alerts.reject-confirmation')
@include('include.remark')

<script>
    let selectedAppointmentId = null;

    function openRejectConfirmationModal(appointmentId) {
        selectedAppointmentId = appointmentId;
        const rejectModal = new bootstrap.Modal(document.getElementById('rejectModal'));
        rejectModal.show();
    }

    document.querySelector('.confirm-reject').addEventListener('click', function() {
        const rejectModal = bootstrap.Modal.getInstance(document.getElementById('rejectModal'));
        rejectModal.hide();

        const rejectReasonModal = new bootstrap.Modal(document.getElementById('rejectReasonModal'));
        rejectReasonModal.show();
    });

    document.querySelector('.submit-reason').addEventListener('click', function() {
        const reasonInput = document.getElementById('rejectionReason');
        const reasonError = document.getElementById('rejectionReasonError');
        const reason = reasonInput.value.trim();
        const submitButton = this; // Reference to the submit button

        if (reason) {
            reasonError.style.display = 'none';
            submitButton.disabled = true;
            submitButton.innerText = 'Submitting...'; 

            updateStatus(selectedAppointmentId, 'Rejected', reason);
        } else {
            reasonError.style.display = 'block';
            reasonInput.focus();
        }
    });

    function updateStatus(appointmentId, status, reason) {
        fetch(`/appointments/update-status/${appointmentId}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ status: status, remark: reason })
        })
        .then(response => {
            if (response.redirected) {
                window.location.href = response.url;
            } else {
                throw new Error('Failed to update status');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Re-enable the button if there's an error
            document.querySelector('.submit-reason').disabled = false;
            document.querySelector('.submit-reason').innerText = 'Submit'; // Revert the button text
        });

    }

    $(document).ready(function () {
        var table = $('#myDataTable').DataTable({
            lengthChange: false,
            buttons: ['copy', 'excel', 'pdf', 'print']
        });

        table.buttons().container()
            .appendTo('#myDataTable_wrapper .col-md-6:eq(0)');
    });

</script>
@endsection
