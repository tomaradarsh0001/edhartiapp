document.addEventListener("DOMContentLoaded", function () {
  var form1 = document.getElementById("appointmentForm");

  // Form fields
  var fullname = document.getElementById("fullname");
  var mobile = document.getElementById("mobile");
  var email = document.getElementById("email");
  var panNumber = document.getElementById("IndPanNumber");
  var appointmentDate = document.getElementById("appointmentDate");
  var meetingTime = document.getElementById("meetingTime");
  var stakeholderProof = document.getElementById("stakeholderProof");

  var locality = document.getElementById("locality");
  var block = document.getElementById("block");
  var plot = document.getElementById("plot");
  var knownas = document.getElementById("knownas");

  var localityFill = document.getElementById("localityFill");
  var blocknoFill = document.getElementById("blocknoFill");
  var plotnoFill = document.getElementById("plotnoFill");
  var knownasFill = document.getElementById("knownasFill");

  var propertyIdCheckbox = document.getElementById("Yes");
  var isStakeholderCheckbox = document.getElementById("isStakeholder");
  var natureOfVisit = document.getElementById("natureOfVisit");
  var meetingPurpose = document.getElementById("meetingPurpose");
  var meetingDescription = document.getElementById("meetingDescription");

  // Error fields
  var fullnameError = document.getElementById("fullnameError");
  var mobileError = document.getElementById("mobileError");
  var emailError = document.getElementById("emailError");
  var panNumberError = document.getElementById("panNumberError");
  var appointmentDateError = document.getElementById("appointmentDateError");
  var meetingTimeError = document.getElementById("meetingTimeError");
  var stakeholderProofError = document.getElementById("stakeholderProofError");

  var localityError = document.getElementById("localityError");
  var blockError = document.getElementById("blockError");
  var plotError = document.getElementById("plotError");
  var knownasError = document.getElementById("knownasError");

  var localityFillError = document.getElementById("localityFillError");
  var blocknoFillError = document.getElementById("blocknoFillError");
  var plotnoFillError = document.getElementById("plotnoFillError");
  var knownasFillError = document.getElementById("knownasFillError");

  var natureOfVisitError = document.getElementById("natureOfVisitError");
  var meetingPurposeError = document.getElementById("meetingPurposeError");
  var meetingDescriptionError = document.getElementById(
    "meetingDescriptionError"
  );

  // Hide or disable unused fields based on the propertyId checkbox
  // function toggleFieldVisibility() {
  //     if (propertyIdCheckbox.checked) {
  //         locality.disabled = true;
  //         block.disabled = true;
  //         plot.disabled = true;
  //         knownas.disabled = true;

  //         localityFill.disabled = false;
  //         blocknoFill.disabled = false;
  //         plotnoFill.disabled = false;
  //         knownasFill.disabled = false;
  //     } else {
  //         locality.disabled = false;
  //         block.disabled = false;
  //         plot.disabled = false;
  //         knownas.disabled = false;

  //         localityFill.disabled = true;
  //         blocknoFill.disabled = true;
  //         plotnoFill.disabled = true;
  //         knownasFill.disabled = true;
  //     }
  // }

  function validateFullName() {
    var fullnameValue = fullname.value.trim();
    if (fullnameValue === "") {
      fullnameError.textContent = "Full Name is required";
      return false;
    } else if (!/^[a-zA-Z\s]+$/.test(fullnameValue)) {
      fullnameError.textContent = "Only alphabets are allowed";
      return false;
    } else {
      fullnameError.textContent = "";
      return true;
    }
  }

  function validateMobile() {
    var mobileValue = mobile.value.trim();
    if (mobileValue === "") {
      mobileError.textContent = "Mobile Number is required";
      return false;
    } else if (!/^\d{10}$/.test(mobileValue)) {
      mobileError.textContent = "Mobile Number must be exactly 10 digits";
      return false;
    } else {
      mobileError.textContent = "";
      return true;
    }
  }

  function validateEmail() {
    var emailValue = email.value.trim();
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (emailValue === "") {
      emailError.textContent = "Email is required";
      return false;
    } else if (!emailPattern.test(emailValue)) {
      emailError.textContent = "Invalid email format";
      return false;
    } else {
      emailError.textContent = "";
      return true;
    }
  }

    function validatePanNumber() {
        var panNumberValue = panNumber.value.trim().toUpperCase();
        if (panNumberValue === '') {
            panNumberError.textContent = 'PAN Number is required';
            // console.log('Error: PAN Number is required. Input:', panNumberValue);
            return false;
        } else if (!/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/.test(panNumberValue)) {
            panNumberError.textContent = 'Invalid PAN format';
            // console.log('Error: Invalid PAN format. Input:', panNumberValue);
            return false;
        } else {
            panNumberError.textContent = '';
            // console.log(panNumberValue);
            return true;
        }
    }
    
    function validateStakeholderProof() {
        if (isStakeholderCheckbox.checked) {
            if (stakeholderProof.files.length > 0) {
                var file = stakeholderProof.files[0];
                if (file.size > 5 * 1024 * 1024) { // 5 MB
                    stakeholderProofError.textContent = 'File size must be less than 5 MB';
                    return false;
                } else if (!file.name.endsWith('.pdf')) {
                    stakeholderProofError.textContent = 'Only PDF files are allowed';
                    return false;
                } else {
                    stakeholderProofError.textContent = '';
                    return true;
                }
            } else {
                stakeholderProofError.textContent = 'Stakeholder proof is required';
                return false;
            }
        } else {
            stakeholderProofError.textContent = '';
            return true;
        }
    }

  function validateNatureOfVisit() {
    var natureOfVisitValue = natureOfVisit.value.trim();
    if (natureOfVisitValue === "") {
      natureOfVisitError.textContent = "Nature of Visit is required";
      return false;
    } else {
      natureOfVisitError.textContent = "";
      return true;
    }
  }

  function validateMeetingPurpose() {
    var meetingPurposeValue = meetingPurpose.value.trim();
    if (meetingPurposeValue === "") {
      meetingPurposeError.textContent = "Meeting Purpose is required";
      return false;
    } else {
      meetingPurposeError.textContent = "";
      return true;
    }
  }

  function validateMeetingDescription() {
    var meetingPurposeValue = meetingPurpose.value.trim();
    var meetingDescriptionValue = meetingDescription.value.trim();

    if (meetingPurposeValue !== "") {
      if (meetingDescriptionValue === "") {
        meetingDescriptionError.textContent = "Meeting Description is required";
        return false;
      } else if (meetingDescriptionValue.length > 255) {
        meetingDescriptionError.textContent =
          "Meeting Description cannot exceed 255 characters";
        return false;
      } else {
        meetingDescriptionError.textContent = "";
        return true;
      }
    } else {
      meetingDescriptionError.textContent = "";
      return true;
    }
  }

  function validateAppointmentDate() {
    var appointmentDateValue = appointmentDate.value.trim();
    if (appointmentDateValue === "") {
      appointmentDateError.textContent = "Appointment Date is required";
      return false;
    } else {
      appointmentDateError.textContent = "";
      return true;
    }
  }

  function validateMeetingTime() {
    var appointmentDateValue = appointmentDate.value.trim();
    var meetingTimeValue = meetingTime.value.trim();

    if (appointmentDateValue !== "" && meetingTimeValue === "") {
      meetingTimeError.textContent = "Meeting Time is required";
      return false;
    } else {
      meetingTimeError.textContent = "";
      return true;
    }
  }

  function validateLocality() {
    if (!propertyIdCheckbox.checked) {
      var localityValue = locality.value.trim();
      if (localityValue === "") {
        localityError.textContent = "Locality is required";
        return false;
      } else {
        localityError.textContent = "";
        return true;
      }
    }
    return true;
  }

  function validateBlock() {
    if (!propertyIdCheckbox.checked) {
      var blockValue = block.value.trim();
      if (blockValue === "") {
        blockError.textContent = "Block is required";
        return false;
      } else {
        blockError.textContent = "";
        return true;
      }
    }
    return true;
  }

  function validatePlot() {
    if (!propertyIdCheckbox.checked) {
      var plotValue = plot.value.trim();
      if (plotValue === "") {
        plotError.textContent = "Plot is required";
        return false;
      } else {
        plotError.textContent = "";
        return true;
      }
    }
    return true;
  }

  function validateKnownAs() {
    if (!propertyIdCheckbox.checked) {
      var knownasValue = knownas.value.trim();
      if (knownasValue === "") {
        knownasError.textContent = "Known As is required";
        return false;
      } else {
        knownasError.textContent = "";
        return true;
      }
    }
    return true;
  }

  function validateLocalityFill() {
    if (propertyIdCheckbox.checked) {
      var localityFillValue = localityFill.value.trim();
      if (localityFillValue === "") {
        localityFillError.textContent = "Locality is required";
        return false;
      } else {
        localityFillError.textContent = "";
        return true;
      }
    }
    return true;
  }

  function validateBlockNoFill() {
    if (propertyIdCheckbox.checked) {
      var blocknoFillValue = blocknoFill.value.trim();
      if (blocknoFillValue === "") {
        blocknoFillError.textContent = "Block No. is required";
        return false;
      } else {
        blocknoFillError.textContent = "";
        return true;
      }
    }
    return true;
  }

  function validatePlotNoFill() {
    if (propertyIdCheckbox.checked) {
      var plotnoFillValue = plotnoFill.value.trim();
      if (plotnoFillValue === "") {
        plotnoFillError.textContent = "Plot No. is required";
        return false;
      } else {
        plotnoFillError.textContent = "";
        return true;
      }
    }
    return true;
  }

  function validateKnownAsFill() {
    if (propertyIdCheckbox.checked) {
      var knownasFillValue = knownasFill.value.trim();
      if (knownasFillValue === "") {
        knownasFillError.textContent = "Known As is required";
        return false;
      } else {
        knownasFillError.textContent = "";
        return true;
      }
    }
    return true;
  }

  function validateForm1() {
    var isFullNameValid = validateFullName();
    var isMobileValid = validateMobile();
    var isEmailValid = validateEmail();
    var isPanNumberValid = validatePanNumber();
    var isAppointmentDate = validateAppointmentDate();
    var isNatureOfVisit = validateNatureOfVisit();
    var isMeetingPurpose = validateMeetingPurpose();
    var isvalidateLocality = validateLocality();
    var isvalidateBlock = validateBlock();
    var isvalidatePlot = validatePlot();
    var isvalidateKnownAs = validateKnownAs();

        return isFullNameValid && isMobileValid && isEmailValid && isPanNumberValid && isAppointmentDate && isNatureOfVisit && isMeetingPurpose && isvalidateLocality && isvalidateBlock && isvalidatePlot && isvalidateKnownAs;
    }

    function validateForm2() {
        var isvalidateLocalityFill = validateLocalityFill();
        var isvalidateBlockNoFill = validateBlockNoFill();
        var isvalidatePlotNoFill = validatePlotNoFill();
        var isvalidateKnownAsFill = validateKnownAsFill();

        return isvalidateLocalityFill && isvalidateBlockNoFill && isvalidatePlotNoFill && isvalidateKnownAsFill;

    }

    function validateForm3() {
        var isStakeholderProof = validateStakeholderProof();

        return isStakeholderProof;
        
    }

    function validateForm4() {
        var isvalidateMeetingDescription = validateMeetingDescription();

        return isvalidateMeetingDescription;
        
    }

    function validateForm5() {
        var isvalidateMeetingTime = validateMeetingTime();

        return isvalidateMeetingTime;
        
    }


    // Attach validation to form submission
    // form1.addEventListener('button', function (event) {
    //     event.preventDefault(); 
    //     if (validateForm1()) {
    //         alert('Form submitted successfully');
    //     }
    // });

    // var AppointmentSubmitButton = document.getElementById('AppointmentSubmitButton');
    // AppointmentSubmitButton.addEventListener('click', function () {
    //     if (validateForm1()) {
    //         this.removeAttribute("type", "submit");
            
    //     } else {
    //         this.setAttribute("type", "button");
    //     }
    //     if(propertyIdCheckbox.checked) {
    //         // validateForm2();
    //         if (validateForm2()) {
    //             this.removeAttribute("type", "submit");
                
    //         } else {
    //             this.setAttribute("type", "button");
    //         }
    //         // console.log('Property_checked');
    //     }
    //     if(isStakeholderCheckbox.checked){
    //         // validateForm3();
    //         if (validateForm3()) {
    //             this.removeAttribute("type", "submit");
                
    //         } else {
    //             this.setAttribute("type", "button");
    //         }
    //         // console.log('Stakeholder_checked');
    //     }
    //     if(meetingPurpose.value){
    //         validateForm4();
    //         // console.log('meetingPurpose_selected');
    //     }

    //     if(appointmentDate.value){
    //         validateForm5();
    //         // console.log('appointmentDate_selected');
    //     }
    // });


});
