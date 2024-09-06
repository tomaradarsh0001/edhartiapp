@extends('layouts.public.app')
@section('title', 'L&DO Visitor Appointment')

@section('content')
<div class="login-8">
    <div class="container">
        <div class="row login-box">
            @if (session('success'))
                <div class="alert alert-success border-0 bg-success alert-dismissible">
                    <div class="text-white">{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('failure'))
                <div class="alert alert-danger border-0 bg-danger alert-dismissible">
                    <div class="text-white">{{ session('failure') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif 

            <div class="card">
                <div class="card-body">
                    <div id="appointment">
                        <style>
                            .form-group {
                            margin-bottom: 15px;
                            }
                            .form-group.form-box {
                                margin-bottom: 15px !important;
                            }
                            .login-8 .ocean {
                                z-index: -1;
                            }
                            .radio-options label {
                                margin-right: 45px;
                                margin-bottom: 0; 
                            }

                            .form-box .form-label {
                                margin-right: 40px;
                                margin-bottom: 0; 
                            }
                        </style>
                        
                        <h3 class="mb-3 form_inner_head-center text-center" style="font-weight: 400;">L&DO Visitor Appointment Form</h3>
                        <hr/>

                        <!-- Start of the Form -->
                        <form action="{{ route('appointmentStore') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div id="appointmentForm" >
                                <div class="row less-padding-input mt-4">
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group form-box">
                                            <input type="text" name="name" class="form-control alpha-only" placeholder="Full Name*" id="fullname">
                                            <div id="fullnameError" class="text-danger text-left"></div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-12">
                                        <div class="form-group form-box relative-input">
                                            <input type="text" name="mobile" id="mobile" maxlength="10" class="form-control numericOnly" placeholder="Mobile Number*"> 
                                            <div id="mobileError" class="text-danger text-left"></div>           
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group form-box relative-input">
                                            <input type="email" name="email" id="email" class="form-control" placeholder="Email Address*"> 
                                            <div id="emailError" class="text-danger text-left"></div>          
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group form-box">
                                            <input type="text" name="pan_number" id="IndPanNumber" class="form-control text-transform-uppercase pan_number_format" placeholder="Pan Number*" maxlength="10">
                                            <div id="panNumberError" class="text-danger text-left"></div>
                                        </div>
                                    </div>
                                </div>

                                <div id="ifYesNotChecked">
                                    <div class="row">
                                        <div class="col-lg-6 col-12">
                                            <div class=" form-group">
                                                <select name="locality" id="locality" class="form-select">
                                                    <option value="">Select Locality</option>
                                                    @foreach($colonyList as $colony)
                                                        <option value="{{ $colony->id }}">{{ $colony->name }}</option>
                                                    @endforeach
                                                </select>
                                            
                                                <div id="localityError" class="text-danger text-left"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <div class=" form-group">
                                                <select name="block" id="block" class="form-select">
                                                    <option value="">Select Block</option>
                                                </select>
                                                <div id="blockError" class="text-danger text-left"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <div class=" form-group">
                                                <select name="plot" id="plot" class="form-select">
                                                    <option value="">Select Plot</option>
                                                </select>
                                                <div id="plotError" class="text-danger text-left"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <div class=" form-group">
                                                <select name="known_as" id="knownas" class="form-select">
                                                    <option value="">Known As</option>
                                                </select>
                                                <div id="knownasError" class="text-danger text-left"></div>
                                            </div>
                                        </div>
                                    </div>                                 
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group form-box">
                                            <div class="mix-field">
                                                <label for="propertyId_property" class="quesLabel">Is property details not found in the above list?</label>
                                                <div class="radio-options ml-5">
                                                    <label for="Yes">
                                                        <input type="checkbox" name="propertyId" value="1" class="form-check" id="Yes"> Yes</label>
                                                </div>
                                            </div>
                                        
                                            <div class="ifyes internal_container my-2" id="ifyes" style="display: none;">
                                                <div class="container-fluid">
                                                    <div class="row less-padding-input">
                                                        <div class="col-lg-6 col-12">
                                                            <div class="form-group form-box">
                                                                <select name="localityFill" id="localityFill" class="form-select">
                                                                    <option value="">Select Locality</option>
                                                                    @foreach($colonyList as $colony)
                                                                        <option value="{{ $colony->id }}">{{ $colony->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div id="localityFillError" class="text-danger text-left"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-12">
                                                            <div class="form-group form-box">
                                                                <input type="text" name="blocknoFill" id="blocknoFill" class="form-control alphaNum-hiphenForwardSlash" placeholder="Block No.">
                                                                <div id="blocknoFillError" class="text-danger text-left"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-12">
                                                            <div class="form-group form-box">
                                                                <input type="text" name="plotnoFill" id="plotnoFill" class="form-control plotNoAlpaMix" placeholder="Property/Plot No.">
                                                                <div id="plotnoFillError" class="text-danger text-left"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-12">
                                                            <div class="form-group form-box">
                                                                <input type="text" name="knownasFill" id="knownasFill" class="form-control alpha-only" placeholder="Known As">
                                                                <div id="knownasFillError" class="text-danger text-left"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group form-box">
                                            <div class="mix-field">
                                                <label for="stakeholderQuestion" class="quesLabel">Are you a Stakeholder?</label>
                                                <div class="radio-options ml-5">
                                                    <label for="isStakeholder">
                                                        <input type="checkbox" name="isStakeholder" value="1" class="form-check" id="isStakeholder"> Yes
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="ifStakeholder internal_container my-2" id="ifStakeholder" style="display: none;">
                                                <div class="container-fluid">
                                                    <div class="row less-padding-input">
                                                        <div class="col-lg-12 col-12">
                                                            <div class="form-group form-box">
                                                                <label for="stakeholderProof" class="form-label">Upload document: (Proof Of Stakeholder)</label>
                                                                <input type="file" name="stakeholderProof" id="stakeholderProof" class="form-control">
                                                                <div id="stakeholderProofError" class="text-danger text-left"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group form-box">
                                            <select name="natureOfVisit" id="natureOfVisit" class="form-select">
                                                <option value="">Select Nature of Visit*</option>
                                                <option value="Online">Online</option>
                                                <option value="Offline">Offline</option>
                                            </select>
                                            <div id="natureOfVisitError" class="text-danger text-left"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group form-box">
                                            <select name="meetingPurpose" id="meetingPurpose" class="form-select">
                                                <option value="">Select Meeting Purpose*</option>
                                                @foreach($meetingPurposes as $purpose)
                                                    <option value="{{ $purpose }}">{{ $purpose }}</option>
                                                @endforeach
                                            </select>
                                            <div id="meetingPurposeError" class="text-danger text-left"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12" id="meetingDescriptionDiv" style="display: none;">
                                        <div class="form-group form-box">
                                            <textarea name="meetingDescription" id="meetingDescription" class="form-control" placeholder="Describe your meeting concern in brief.*" maxlength="255"></textarea>
                                            <div id="meetingDescriptionError" class="text-danger text-left"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group form-box">
                                            <input type="text" name="appointmentDate" id="appointmentDate" class="form-control" placeholder="Select an appointment date*">
                                            <div id="appointmentDateError" class="text-danger text-left"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12" id="timeSlotDiv" style="display: none;">
                                        <div class="form-group form-box">
                                            <select name="meetingTime" id="meetingTime" class="form-select">
                                                <option value="">Select a time slot*</option>
                                            </select>
                                            <div id="meetingTimeError" class="text-danger text-left"></div>
                                        </div>
                                    </div>
                                </div>
                            
                                <button type="button" class="btn btn-primary btn-lg btn-theme mt-4" id="AppointmentSubmitButton">Submit</button>
                            </div>
                            
                        </form>
                        <!-- End of the Form -->

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ocean">
        <div class="wave"></div>
        <div class="wave"></div>
    </div>
</div>
<!-- 
<script src="{{ asset('js/appointment-validation.js') }}"></script> -->

<script>
    document.getElementById('isStakeholder').addEventListener('change', function () {
        var stakeholderDiv = document.getElementById('ifStakeholder');
        if (this.checked) {
            stakeholderDiv.style.display = 'block';
        } else {
            stakeholderDiv.style.display = 'none';
        }
    });

    document.getElementById('meetingPurpose').addEventListener('change', function () {
        var meetingDescriptionDiv = document.getElementById('meetingDescriptionDiv');
        if (this.value !== "Select Meeting Purpose*") {
            meetingDescriptionDiv.style.display = 'block';
        } else {
            meetingDescriptionDiv.style.display = 'none';
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
    const appointmentDateElement = document.getElementById('appointmentDate');
    const timeSlotDiv = document.getElementById('timeSlotDiv');
    const meetingTimeElement = document.getElementById('meetingTime');

    if (appointmentDateElement) {
        let fullyBookedDates = [];

        try {
            // Fetch fully booked dates initially
            fetch('/appointments/get-fully-booked-dates')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Fully booked dates from server:', data);

                    // Convert the dates to Asia/Kolkata timezone
                    fullyBookedDates = data.map(dateString => {
                        const date = new Date(dateString);
                        const options = { timeZone: 'Asia/Kolkata', year: 'numeric', month: '2-digit', day: '2-digit'};
                        const kolkataDate = new Intl.DateTimeFormat('en-CA', options).format(date);
                        return kolkataDate;
                    });

                    console.log('Converted fully booked dates:', fullyBookedDates);

                    flatpickr(appointmentDateElement, {
                        dateFormat: "Y-m-d",
                        minDate: "today",
                        enable: [
                            function(date) {
                                try {
                                    const year = date.getFullYear();
                                    const month = ("0" + (date.getMonth() + 1)).slice(-2);  // Months are zero-based
                                    const day = ("0" + date.getDate()).slice(-2);

                                    const dateString = `${year}-${month}-${day}`;

                                    const dayOfWeek = date.getDay();
                                    const isValidDay = (dayOfWeek === 3 || dayOfWeek === 4 || dayOfWeek === 5);

                                    // Check if this date is fully booked
                                    const isFullyBooked = fullyBookedDates.includes(dateString);

                                    // Disable the date if it is fully booked
                                    return isValidDay && !isFullyBooked;
                                } catch (error) {
                                    console.error('Error during date check:', error);
                                    return false;
                                }
                            }
                        ],
                        onChange: function(selectedDates, dateStr, instance) {
                            if (dateStr) {
                                fetchAvailableTimeSlots(dateStr);
                            }
                        }
                    });

                })
                .catch(error => {
                    console.error('Error fetching fully booked dates:', error);
                });
        } catch (error) {
            console.error('Error in setting up date picker:', error);
        }

        function fetchAvailableTimeSlots(date) {
            try {
                fetch(`/appointments/get-available-time-slots?date=${date}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Available time slots for date', date, ':', data);
                        meetingTimeElement.innerHTML = '<option value="">Select a time slot</option>';

                        if (data.length > 0) {
                            data.forEach(slot => {
                                let option = document.createElement('option');
                                option.value = slot;
                                option.textContent = slot;
                                meetingTimeElement.appendChild(option);
                            });
                            timeSlotDiv.style.display = 'block';
                        } else {
                            timeSlotDiv.style.display = 'none';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching time slots:', error);
                    });
            } catch (error) {
                console.error('Error in fetching available time slots:', error);
            }
        }
    }
});

</script>
@endsection
