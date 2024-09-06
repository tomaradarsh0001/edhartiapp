// document.addEventListener('DOMContentLoaded', () => {
//     const form = document.getElementById('otp-form')
//     const inputs = [...form.querySelectorAll('input[type=text]')]
//     const submit = form.querySelector('#verifyMobileOtpBtn')


//     const form2 = document.getElementById('otp-form-email')
//     const inputs2 = [...form2.querySelectorAll('input[type=text]')]
//     const submit2 = form2.querySelector('#verifyEmailOtpBtn')


//     const form3 = document.getElementById('org-otp-form')
//     const inputs3 = [...form3.querySelectorAll('input[type=text]')]
//     const submit3 = form3.querySelector('#orgVerifyMobileOtpBtn')

//     const form4 = document.getElementById('org-otp-form-email')
//     const inputs4 = [...form4.querySelectorAll('input[type=text]')]
//     const submit4 = form4.querySelector('#orgVerifyEmailOtpBtn')



//     const handleKeyDown = (e) => {
//         if (
//             !/^[0-9]{1}$/.test(e.key)
//             && e.key !== 'Backspace'
//             && e.key !== 'Delete'
//             && e.key !== 'Tab'
//             && !e.metaKey
//         ) {
//             e.preventDefault()
//         }

//         if (e.key === 'Delete' || e.key === 'Backspace' && index >= 0) {
//             const index = inputs.indexOf(e.target);
//             if (index > 0) {
//                 inputs[index - 1].value = '';
//                 inputs[index - 1].focus();
//             }

//             const index2 = inputs2.indexOf(e.target);
//             if (index2 > 0) {
//                 inputs2[index2 - 1].value = '';
//                 inputs2[index2 - 1].focus();
//             }

//             const index3 = inputs3.indexOf(e.target);
//             if (index3 > 0) {
//                 inputs3[index3 - 1].value = '';
//                 inputs3[index3 - 1].focus();
//             }

//             const index4 = inputs4.indexOf(e.target);
//             if (index4 > 0) {
//                 inputs4[index4 - 1].value = '';
//                 inputs4[index4 - 1].focus();
//             }
//         }
//     }

//     const handleInput = (e) => {
//         const { target } = e
//         const index = inputs.indexOf(target)
//         if (target.value) {
//             if (index < inputs.length - 1) {
//                 inputs[index + 1].focus()
//             } else {
//                 submit.focus()
//             }
//         }
//     }
//     const handleInput2 = (e) => {
//         const { target } = e
//         const index2 = inputs2.indexOf(target)
//         if (target.value) {
//             if (index2 < inputs2.length - 1) {
//                 inputs2[index2 + 1].focus()
//             } else {
//                 submit2.focus()
//             }
//         }
//     }

//     const handleInput3 = (e) => {
//         const { target } = e
//         const index3 = inputs3.indexOf(target)
//         if (target.value) {
//             if (index3 < inputs3.length - 1) {
//                 inputs3[index3 + 1].focus()
//             } else {
//                 submit3.focus()
//             }
//         }
//     }

//     const handleInput4 = (e) => {
//         const { target } = e
//         const index4 = inputs4.indexOf(target)
//         if (target.value) {
//             if (index4 < inputs4.length - 1) {
//                 inputs4[index4 + 1].focus()
//             } else {
//                 submit4.focus()
//             }
//         }
//     }

//     const handleFocus = (e) => {
//         e.target.select()
//     }

//     const handlePaste = (e) => {
//         e.preventDefault()
//         const text = e.clipboardData.getData('text')
//         if (!new RegExp(`^[0-9]{${inputs.length}}$`).test(text)) {
//             return
//         }
//         const digits = text.split('')
//         inputs.forEach((input, index) => input.value = digits[index])
//         submit.focus()

//         if (!new RegExp(`^[0-9]{${inputs2.length}}$`).test(text)) {
//             return
//         }
//         inputs2.forEach((input, index) => input.value = digits[index])
//         submit2.focus()


//         if (!new RegExp(`^[0-9]{${inputs3.length}}$`).test(text)) {
//             return
//         }
//         inputs3.forEach((input, index) => input.value = digits[index])
//         submit3.focus()

//         if (!new RegExp(`^[0-9]{${inputs4.length}}$`).test(text)) {
//             return
//         }
//         inputs4.forEach((input, index) => input.value = digits[index])
//         submit4.focus()
//     }

//     inputs.forEach((input) => {
//         input.addEventListener('input', handleInput)
//         input.addEventListener('keydown', handleKeyDown)
//         input.addEventListener('focus', handleFocus)
//         input.addEventListener('paste', handlePaste)
//     })

//     inputs2.forEach((input) => {
//         input.addEventListener('input', handleInput2)
//         input.addEventListener('keydown', handleKeyDown)
//         input.addEventListener('focus', handleFocus)
//         input.addEventListener('paste', handlePaste)
//     })

//     inputs3.forEach((input) => {
//         input.addEventListener('input', handleInput3)
//         input.addEventListener('keydown', handleKeyDown)
//         input.addEventListener('focus', handleFocus)
//         input.addEventListener('paste', handlePaste)
//     })

//     inputs4.forEach((input) => {
//         input.addEventListener('input', handleInput4)
//         input.addEventListener('keydown', handleKeyDown)
//         input.addEventListener('focus', handleFocus)
//         input.addEventListener('paste', handlePaste)
//     })
// })

document.addEventListener('DOMContentLoaded', () => {
    const setupForm = (formId, submitId) => {
        const form = document.getElementById(formId);
        const inputs = [...form.querySelectorAll('input[type=text]')];
        const submit = form.querySelector(submitId);

        const handleKeyDown = (e) => {
            const index = inputs.indexOf(e.target);

            if (!/^[0-9]{1}$/.test(e.key) && e.key !== 'Backspace' && e.key !== 'Delete' && e.key !== 'Tab' && !e.metaKey) {
                e.preventDefault();
            }

            if ((e.key === 'Delete' || e.key === 'Backspace') && index >= 0) {
                if (inputs[index].value === '') {
                    if (index > 0) {
                        inputs[index - 1].focus();
                        inputs[index - 1].value = '';
                    }
                } else {
                    inputs[index].value = '';  // Clear current input if not empty
                }
                e.preventDefault();  // Prevent default behavior
            }
        };

        const handleInput = (e) => {
            const { target } = e;
            const index = inputs.indexOf(target);
            if (target.value && index < inputs.length - 1) {
                inputs[index + 1].focus();
            } else if (index === inputs.length - 1) {
                submit.focus();
            }
        };

        const handleFocus = (e) => {
            e.target.select();
        };

        const handlePaste = (e) => {
            e.preventDefault();
            const text = e.clipboardData.getData('text');
            if (!/^[0-9]{1,}$/.test(text)) return;
            const digits = text.split('').slice(0, inputs.length);
            inputs.forEach((input, i) => input.value = digits[i] || '');
            if (digits.length === inputs.length) {
                submit.focus();
            }
        };

        inputs.forEach((input) => {
            input.addEventListener('input', handleInput);
            input.addEventListener('keydown', handleKeyDown);
            input.addEventListener('focus', handleFocus);
            input.addEventListener('paste', handlePaste);
        });
    };

    setupForm('otp-form', '#verifyMobileOtpBtn');
    setupForm('otp-form-email', '#verifyEmailOtpBtn');
    setupForm('org-otp-form', '#orgVerifyMobileOtpBtn');
    setupForm('org-otp-form-email', '#orgVerifyEmailOtpBtn');
});

// Field Data Validation in All Inputs - 31-07-2024 by Diwakar Sinha

$(document).ready(function () {
    $('.alpha-only').keypress(function (event) {
        var charCode = event.which;
        // Allow only alphabetic characters (a-z, A-Z), space (32), and dot (46)
        if (
            (charCode < 65 || (charCode > 90 && charCode < 97) || charCode > 122) &&
            charCode !== 32 && charCode !== 46
        ) {
            event.preventDefault();
        }
    });
    $('.numericDecimal').on('input', function () {
        var value = $(this).val();
        if (!/^\d*\.?\d*$/.test(value)) {
            $(this).val(value.slice(0, -1));
        }
    });

    $(".numericOnly").on('input', function (e) {
        $(this).val($(this).val().replace(/[^0-9]/g, ''));
    });

    $('.alphaNum-hiphenForwardSlash').on('input', function () {
        var value = $(this).val();
        // Allow only alphanumeric, hyphen, and forward slash
        var filteredValue = value.replace(/[^a-zA-Z0-9\-\/]/g, '');
        $(this).val(filteredValue);
    });

    //   Date Format
    $('.date_format').on('input', function (e) {
        var input = $(this).val().replace(/\D/g, '');
        if (input.length > 8) {
            input = input.substring(0, 8);
        }

        var formattedDate = '';
        if (input.length > 0) {
            formattedDate = input.substring(0, 2);
        }
        if (input.length >= 3) {
            formattedDate += '-' + input.substring(2, 4);
        }
        if (input.length >= 5) {
            formattedDate += '-' + input.substring(4, 8);
        }

        $(this).val(formattedDate);
    });

    // Plot No.
    $('.plotNoAlpaMix').on('input', function () {
        var pattern = /[^a-zA-Z0-9+\-/]/g;
        var sanitizedValue = $(this).val().replace(pattern, '');
        $(this).val(sanitizedValue);
    });
    $('.pan_number_format').on('keypress', function (event) {
        var charCode = event.which;

        if (charCode === 0 || charCode === 8 || charCode === 9 || charCode === 13) {
            return;
        }

        var charStr = String.fromCharCode(charCode).toUpperCase();

        var currentLength = $(this).val().length;

        if (currentLength < 5 && !/[A-Z]/.test(charStr)) {
            event.preventDefault();
        }

        else if (currentLength >= 5 && currentLength < 9 && !/[0-9]/.test(charStr)) {
            event.preventDefault();
        }

        else if (currentLength === 9 && !/[A-Z]/.test(charStr)) {
            event.preventDefault();
        }
    });
});

// Required Validation - 31-07-2024 by Diwakar Sinha

document.addEventListener('DOMContentLoaded', function () {
    var form1 = document.getElementById('propertyownerDiv');
    var form2 = document.getElementById('organizationDiv');

    // Form 1 Fields
    var IndFullName = document.getElementById('indfullname');
    var IndGender = document.getElementById('Indgender');
    var IndSecondName = document.getElementById('IndSecondName');
    var Indmobile = document.getElementById('mobileInv');
    var IndEmail = document.getElementById('emailInv');
    var IndPanNumber = document.getElementById('IndPanNumber');
    var IndAadhar = document.getElementById('IndAadhar');

    var locality = document.getElementById('locality');
    var block = document.getElementById('block');
    var plot = document.getElementById('plot');
    var landUse = document.getElementById('landUse');
    var landUseSubtype = document.getElementById('landUseSubtype');
   
    var IndSaleDeed = document.getElementById('IndSaleDeed');
    var IndBuildAgree = document.getElementById('IndBuildAgree');
    var IndLeaseDeed = document.getElementById('IndLeaseDeed');
    var IndSubMut = document.getElementById('IndSubMut');

    var IndOwnerLess = document.getElementById('IndOwnerLess');

    var IndConsent = document.getElementById('IndConsent');
    // Form 1 Errors
    var IndFullNameError = document.getElementById('IndFullNameError');
    var IndGenderError = document.getElementById('IndGenderError');
    var IndSecondNameError = document.getElementById('IndSecondNameError');
    var IndMobileError = document.getElementById('IndMobileError');
    var IndEmailError = document.getElementById('IndEmailError');
    var IndPanNumberError = document.getElementById('IndPanNumberError');
    var IndAadharError = document.getElementById('IndAadharError');

    var localityError = document.getElementById('localityError');
    var blockError = document.getElementById('blockError');
    var plotError = document.getElementById('plotError');
    var landUseError = document.getElementById('landUseError');
    var landUseSubtypeError = document.getElementById('landUseSubtypeError');

    var IndSaleDeedError = document.getElementById('IndSaleDeedError');
    var IndBuildAgreeError = document.getElementById('IndBuildAgreeError');
    var IndLeaseDeedError = document.getElementById('IndLeaseDeedError');
    var IndSubMutError = document.getElementById('IndSubMutError');

    var IndOwnerLessError = document.getElementById('IndOwnerLessError');

    var IndConsentError = document.getElementById('IndConsentError');

    function validateIndConsent() {
        if (!IndConsent.checked) {
            IndConsentError.textContent = 'Field is required';
            IndConsentError.style.display = 'block';
            return false;
        } else {
            IndConsentError.style.display = 'none';
            return true;
        }
    }

    function validateIndFullName() {
        var IndFullNameValue = IndFullName.value.trim();
        if (IndFullNameValue === '') {
            IndFullNameError.textContent = 'Full Name is required';
            IndFullNameError.style.display = 'block';
            return false;
        } else {
            IndFullNameError.style.display = 'none';
            return true;
        }
    }

    function validateIndGender() {
        var IndGenderValue = IndGender.value.trim();
        if (IndGenderValue === '') {
            IndGenderError.textContent = 'Gender is required';
            IndGenderError.style.display = 'block';
            return false;
        } else {
            IndGenderError.style.display = 'none';
            return true;
        }
    }

    function validateIndSecondName() {
        var IndSecondNameValue = IndSecondName.value.trim();
        if (IndSecondNameValue === '') {
            IndSecondNameError.textContent = 'Full Name is required';
            IndSecondNameError.style.display = 'block';
            return false;
        } else {
            IndSecondNameError.style.display = 'none';
            return true;
        }
    }

    function validateIndMobile() {
        var IndMobileValue = Indmobile.value.trim();
        var dataIdValue = Indmobile.getAttribute('data-id');
        if (IndMobileValue === '') {
            IndMobileError.textContent = 'Mobile Number is required';
            IndMobileError.style.display = 'block';
            return false;
        } else if(dataIdValue == "0"){
            IndMobileError.textContent = 'Please verify your mobile number';
            IndMobileError.style.display = 'block';
            return false;
        }else {
            IndMobileError.style.display = 'none';
            return true;
        }
    }

    function validateIndEmail() {
        var IndEmailValue = IndEmail.value.trim();
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        var dataIdValue = IndEmail.getAttribute('data-id');
    
        if (IndEmailValue === '') {
            IndEmailError.textContent = 'Email is required';
            IndEmailError.style.display = 'block';
            return false;
        } else if (!emailPattern.test(IndEmailValue)) {
            IndEmailError.textContent = 'Invalid email format';
            IndEmailError.style.display = 'block';
            return false;
        } else if(dataIdValue == "0"){
            IndEmailError.textContent = 'Please verify your email';
            IndEmailError.style.display = 'block';
            return false;
        }else {
            IndEmailError.style.display = 'none';
            return true;
        }
    }
    
    function validateIndPAN() {
        var IndPanNumberValue = IndPanNumber.value.trim();
        if (IndPanNumberValue === '') {
            IndPanNumberError.textContent = 'PAN Number is required';
            IndPanNumberError.style.display = 'block';
            return false;
        } else {
            IndPanNumberError.style.display = 'none';
            return true;
        }
    }

    function validateIndAadhar() {
        var IndAadharValue = IndAadhar.value.trim();
        if (IndAadharValue === '') {
            IndAadharError.textContent = 'Aadhar Number is required';
            IndAadharError.style.display = 'block';
            return false;
        } else {
            IndAadharError.style.display = 'none';
            return true;
        }
    }

    function validateIndLocality() {
        var localityValue = locality.value.trim();
        if (localityValue === '') {
            localityError.textContent = 'Locality is required';
            localityError.style.display = 'block';
            return false;
        } else {
            localityError.style.display = 'none';
            return true;
        }
    }

    function validateIndblock() {
        var blockValue = block.value.trim();
        if (blockValue === '') {
            blockError.textContent = 'Block is required';
            blockError.style.display = 'block';
            return false;
        } else {
            blockError.style.display = 'none';
            return true;
        }
    }

    function validateIndplot() {
        var plotValue = plot.value.trim();
        if (plotValue === '') {
            plotError.textContent = 'Plot is required';
            plotError.style.display = 'block';
            return false;
        } else {
            plotError.style.display = 'none';
            return true;
        }
    }

    function validateIndlandUse() {
        var landUseValue = landUse.value.trim();
        if (landUseValue === '') {
            landUseError.textContent = 'Land Use is required';
            landUseError.style.display = 'block';
            return false;
        } else {
            landUseError.style.display = 'none';
            return true;
        }
    }

    function validateIndlandUseSubtype() {
        var landUseSubtypeValue = landUseSubtype.value.trim();
        if (landUseSubtypeValue === '') {
            landUseSubtypeError.textContent = 'Land Use SubType is required';
            landUseSubtypeError.style.display = 'block';
            return false;
        } else {
            landUseSubtypeError.style.display = 'none';
            return true;
        }
    }

    // Doc

    function validateIndSaleDeed() {
        if (IndSaleDeed.files.length === 0) {
            IndSaleDeedError.textContent = 'This file is required';
            IndSaleDeedError.style.display = 'block';
            return false;
        } else {
            var file = IndSaleDeed.files[0];
            var fileType = file.type;
            var fileName = file.name;
            var validExtension = /(\.pdf)$/i;
    
            if (!validExtension.test(fileName)) {
                IndSaleDeedError.textContent = 'Only PDF files are allowed';
                IndSaleDeedError.style.display = 'block';
                return false;
            } else {
                IndSaleDeedError.style.display = 'none';
                return true;
            }
        }
    }
    

    function validateIndBuildAgree() {
        if (IndBuildAgree.files.length === 0) {
            IndBuildAgreeError.textContent = 'This file is required';
            IndBuildAgreeError.style.display = 'block';
            return false;
        } else {
            var file = IndBuildAgree.files[0];
            var fileType = file.type;
            var fileName = file.name;
            var validExtension = /(\.pdf)$/i;
    
            if (!validExtension.test(fileName)) {
                IndBuildAgreeError.textContent = 'Only PDF files are allowed';
                IndBuildAgreeError.style.display = 'block';
                return false;
            } else {
                IndBuildAgreeError.style.display = 'none';
                return true;
            }
        }
    }

    function validateIndLeaseDeed() {
        if (IndLeaseDeed.files.length === 0) {
            IndLeaseDeedError.textContent = 'This file is required';
            IndLeaseDeedError.style.display = 'block';
            return false;
        } else {
            var file = IndLeaseDeed.files[0];
            var fileType = file.type;
            var fileName = file.name;
            var validExtension = /(\.pdf)$/i;
    
            if (!validExtension.test(fileName)) {
                IndLeaseDeedError.textContent = 'Only PDF files are allowed';
                IndLeaseDeedError.style.display = 'block';
                return false;
            } else {
                IndLeaseDeedError.style.display = 'none';
                return true;
            }
        }
    }

    function validateIndSubMut() {
        if (IndSubMut.files.length === 0) {
            IndSubMutError.textContent = 'This file is required';
            IndSubMutError.style.display = 'block';
            return false;
        } else {
            var file = IndSubMut.files[0];
            var fileType = file.type;
            var fileName = file.name;
            var validExtension = /(\.pdf)$/i;
    
            if (!validExtension.test(fileName)) {
                IndSubMutError.textContent = 'Only PDF files are allowed';
                IndSubMutError.style.display = 'block';
                return false;
            } else {
                IndSubMutError.style.display = 'none';
                return true;
            }
        }
    }

    function validateIndOwnerLess() {
        if (IndOwnerLess.files.length === 0) {
            IndOwnerLessError.textContent = 'This file is required';
            IndOwnerLessError.style.display = 'block';
            return false;
        } else {
            var file = IndOwnerLess.files[0];
            var fileType = file.type;
            var fileName = file.name;
            var validExtension = /(\.pdf)$/i;
    
            if (!validExtension.test(fileName)) {
                IndOwnerLessError.textContent = 'Only PDF files are allowed';
                IndOwnerLessError.style.display = 'block';
                return false;
            } else {
                IndOwnerLessError.style.display = 'none';
                return true;
            }
        }
    }

        // Validate Form 1
        function validateForm1() {
            var isIndFullNameValid = validateIndFullName();
            var isIndGenderValid = validateIndGender();
            var isIndSecondNameValid = validateIndSecondName();
            var isIndMobileValid = validateIndMobile();
            var isIndEmailValid = validateIndEmail();
    
           
    
            var isIndPANValid = validateIndPAN();
            var isIndAadharValid = validateIndAadhar();
            // Doc
            var isIndSaleDeedValid = validateIndSaleDeed();
            var isIndBuildAgreeValid = validateIndBuildAgree();
            var isIndLeaseDeedValid = validateIndLeaseDeed();
            var isIndSubMutValid = validateIndSubMut();
    
            var isIndOwnerLessValid = validateIndOwnerLess();

            var isIndConsentValid = validateIndConsent();
    
            return isIndFullNameValid && isIndGenderValid && isIndSecondNameValid && isIndPANValid && isIndAadharValid && isIndMobileValid && isIndEmailValid && isIndSaleDeedValid && isIndBuildAgreeValid && isIndLeaseDeedValid && isIndSubMutValid && isIndOwnerLessValid && isIndConsentValid;
        }

    function addressvalidationbeforecheck() {
        var isIndLocalityValid = validateIndLocality();
        var isIndblockValid = validateIndblock();
        var isIndIndplotValid = validateIndplot();
        var isIndIndlandUseValid = validateIndlandUse();
        var isIndIndlandUseSubtypeValid = validateIndlandUseSubtype();

        return isIndLocalityValid && isIndblockValid && isIndIndplotValid && isIndIndlandUseValid && isIndIndlandUseSubtypeValid;
    }

            // Address After Check
            var localityFill = document.getElementById('localityFill');
            var blocknoInvFill = document.getElementById('blocknoInvFill');
            var plotnoInvFill = document.getElementById('plotnoInvFill');
            var landUseInvFill = document.getElementById('landUseInvFill');
            var landUseSubtypeInvFill = document.getElementById('landUseSubtypeInvFill');

            // Error
            var localityFillError = document.getElementById('localityFillError');
            var blocknoInvFillError = document.getElementById('blocknoInvFillError');
            var plotnoInvFillError = document.getElementById('plotnoInvFillError');
            var landUseInvFillError = document.getElementById('landUseInvFillError');
            var landUseSubtypeInvFillError = document.getElementById('landUseSubtypeInvFillError');


            function validateIndlocalityFill() {
                var localityFillValue = localityFill.value.trim();
                if (localityFillValue === '') {
                    localityFillError.textContent = 'Locality is required';
                    localityFillError.style.display = 'block';
                    return false;
                } else {
                    localityFillError.style.display = 'none';
                    return true;
                }
            }
        
            function validateIndblocknoInvFill() {
                var blocknoInvFillValue = blocknoInvFill.value.trim();
                if (blocknoInvFillValue === '') {
                    blocknoInvFillError.textContent = 'Block is required';
                    blocknoInvFillError.style.display = 'block';
                    return false;
                } else {
                    blocknoInvFillError.style.display = 'none';
                    return true;
                }
            }
        
            function validateIndplotnoInvFill() {
                var plotnoInvFillValue = plotnoInvFill.value.trim();
                if (plotnoInvFillValue === '') {
                    plotnoInvFillError.textContent = 'plotnoInvFill is required';
                    plotnoInvFillError.style.display = 'block';
                    return false;
                } else {
                    plotnoInvFillError.style.display = 'none';
                    return true;
                }
            }
        
            function validateIndlandUseInvFill() {
                var landUseInvFillValue = landUseInvFill.value.trim();
                if (landUseInvFillValue === '') {
                    landUseInvFillError.textContent = 'Land Use is required';
                    landUseInvFillError.style.display = 'block';
                    return false;
                } else {
                    landUseInvFillError.style.display = 'none';
                    return true;
                }
            }
        
            function validateIndlandUseSubtypeInvFill() {
                var landUseSubtypeInvFillValue = landUseSubtypeInvFill.value.trim();
                if (landUseSubtypeInvFillValue === '') {
                    landUseSubtypeInvFillError.textContent = 'Land Use SubType is required';
                    landUseSubtypeInvFillError.style.display = 'block';
                    return false;
                } else {
                    landUseSubtypeInvFillError.style.display = 'none';
                    return true;
                }
            }
    function addressvalidationaftercheck() {
        var isInlocalityFillValid = validateIndlocalityFill();
        var isIndblocknoInvFillValid = validateIndblocknoInvFill();
        var isIndIndplotnoInvFillValid = validateIndplotnoInvFill();
        var isIndIndlandUseInvFillValid = validateIndlandUseInvFill();
        var isIndIndlandUseSubtypeInvFillValid = validateIndlandUseSubtypeInvFill();

        return isInlocalityFillValid && isIndblocknoInvFillValid && isIndIndplotnoInvFillValid && isIndIndlandUseInvFillValid && isIndIndlandUseSubtypeInvFillValid;
    }

    var IndsubmitButton = document.getElementById('IndsubmitButton');
    IndsubmitButton.addEventListener('click', function (event) {
        event.preventDefault();

        if (validateForm1()) {
            var isYesChecked = document.getElementById('Yes').checked;
            var addressIsValid = false;

            if (isYesChecked) {
                addressIsValid = addressvalidationaftercheck();
            } else {
                addressIsValid = addressvalidationbeforecheck();
            }

            if (addressIsValid) {
                form1.submit();
            }
        }
    });

    form1.addEventListener('submit', function (event) {
        event.preventDefault();

        if (validateForm1() && (addressvalidationbeforecheck() || addressvalidationaftercheck())) {
            alert('Form submitted successfully');
            form1.submit();
        }
    });

    // Form2

     // Form 2 Fields
     var OrgName = document.getElementById('OrgName');
     var OrgPAN = document.getElementById('OrgPAN');
     var OrgNameAuthSign = document.getElementById('OrgNameAuthSign');
     var OrgAuthsignatoryMobile = document.getElementById('authsignatory_mobile');
     var OrgEmailAuthSign = document.getElementById('emailauthsignatory');
     var orgAadharAuth = document.getElementById('orgAadharAuth');

     var OrgSignAuthDoc = document.getElementById('OrgSignAuthDoc');

     var locality_org = document.getElementById('locality_org');
     var block_org = document.getElementById('block_org');
     var plot_org = document.getElementById('plot_org');
     var landUse_org = document.getElementById('landUse_org');
     var landUseSubtype_org = document.getElementById('landUseSubtype_org');


     var OrgSaleDeedDoc = document.getElementById('OrgSaleDeedDoc');
     var OrgBuildAgreeDoc = document.getElementById('OrgBuildAgreeDoc');
     var OrgLeaseDeedDoc = document.getElementById('OrgLeaseDeedDoc');
     var OrgSubMutDoc = document.getElementById('OrgSubMutDoc');
     var OrgConsent = document.getElementById('OrgConsent');

      // Form 2 Errors
    var OrgNameError = document.getElementById('OrgNameError');
    var OrgPANError = document.getElementById('OrgPANError');
    var OrgNameAuthSignError = document.getElementById('OrgNameAuthSignError');
    var OrgMobileAuthErrorError = document.getElementById('OrgMobileAuthError');
    var OrgEmailAuthSignError = document.getElementById('OrgEmailAuthSignError');
    var orgAadharAuthError = document.getElementById('orgAadharAuthError');

    var OrgSignAuthDocError = document.getElementById('OrgSignAuthDocError');

    
    var locality_orgError = document.getElementById('locality_orgError');
    var block_orgError = document.getElementById('block_orgError');
    var plot_orgError = document.getElementById('plot_orgError');
    var landUse_orgError = document.getElementById('landUse_orgError');
    var landUseSubtype_orgError = document.getElementById('landUseSubtype_orgError');


    var OrgSaleDeedDocError = document.getElementById('OrgSaleDeedDocError');
    var OrgBuildAgreeDocError = document.getElementById('OrgBuildAgreeDocError');
    var OrgLeaseDeedDocError = document.getElementById('OrgLeaseDeedDocError');
    var OrgSubMutDocError = document.getElementById('OrgSubMutDocError');
    var OrgConsentError = document.getElementById('OrgConsentError');

    function validateOrgConsent() {
        if (!OrgConsent.checked) {
            OrgConsentError.textContent = 'Field is required';
            OrgConsentError.style.display = 'block';
            return false;
        } else {
            OrgConsentError.style.display = 'none';
            return true;
        }
    }

    function validateOrgName() {
        var OrgNameValue = OrgName.value.trim();
        if (OrgNameValue === '') {
            OrgNameError.textContent = 'Organization Name is required';
            OrgNameError.style.display = 'block';
            return false;
        } else {
            OrgNameError.style.display = 'none';
            return true;
        }
    }

    function validateOrgPAN() {
        var OrgPANValue = OrgPAN.value.trim();
        if (OrgPANValue === '') {
            OrgPANError.textContent = 'Organisation PAN Number is required';
            OrgPANError.style.display = 'block';
            return false;
        } else {
            OrgPANError.style.display = 'none';
            return true;
        }
    }

    function validateOrgNameAuthSign() {
        var OrgNameAuthSignValue = OrgNameAuthSign.value.trim();
        if (OrgNameAuthSignValue === '') {
            OrgNameAuthSignError.textContent = 'Authorised Signatory Name is required';
            OrgNameAuthSignError.style.display = 'block';
            return false;
        } else {
            OrgNameAuthSignError.style.display = 'none';
            return true;
        }
    }

    function validateOrgAuthsignatoryMobile() {
        var OrgAuthsignatoryMobileValue = OrgAuthsignatoryMobile.value.trim();
        var OrgDataIdMobileValue = OrgAuthsignatoryMobile.getAttribute('data-id');
        if (OrgAuthsignatoryMobileValue === '') {
            OrgMobileAuthErrorError.textContent = 'Authorised Mobile Number is required';
            OrgMobileAuthErrorError.style.display = 'block';
            return false;
        } 
        else if(OrgDataIdMobileValue == "0"){
            OrgMobileAuthErrorError.textContent = 'Please verify your mobile number';
            OrgMobileAuthErrorError.style.display = 'block';
            return false;
        } else {
            OrgMobileAuthErrorError.style.display = 'none';
            return true;
        }
    }

    function validateOrgEmailAuthSign() {
        var OrgEmailAuthSignValue = OrgEmailAuthSign.value.trim();
        var OrgDataIdValue = OrgEmailAuthSign.getAttribute('data-id');
        if (OrgEmailAuthSignValue === '') {
            OrgEmailAuthSignError.textContent = 'Authorised Email is required';
            OrgEmailAuthSignError.style.display = 'block';
            return false;
        } else if(OrgDataIdValue == "0"){
            OrgEmailAuthSignError.textContent = 'Please verify your email';
            OrgEmailAuthSignError.style.display = 'block';
            return false;
        } else {
            OrgEmailAuthSignError.style.display = 'none';
            return true;
        }
    }

    function validateOrgAadharAuth() {
        var orgAadharAuthValue = orgAadharAuth.value.trim();
        if (orgAadharAuthValue === '') {
            orgAadharAuthError.textContent = 'Aadhar Authorised is required';
            orgAadharAuthError.style.display = 'block';
            return false;
        } else {
            orgAadharAuthError.style.display = 'none';
            return true;
        }
    }


    function validateOrgSignAuthDoc() {
        if (OrgSignAuthDoc.files.length === 0) {
            OrgSignAuthDocError.textContent = 'This file is required';
            OrgSignAuthDocError.style.display = 'block';
            return false;
        } else {
            var file = OrgSignAuthDoc.files[0];
            var fileType = file.type;
            var fileName = file.name;
            var validExtension = /(\.pdf)$/i;
    
            if (!validExtension.test(fileName)) {
                OrgSignAuthDocError.textContent = 'Only PDF files are allowed';
                OrgSignAuthDocError.style.display = 'block';
                return false;
            } else {
                OrgSignAuthDocError.style.display = 'none';
                return true;
            }
        }
    }


    function validateOrgLocality() {
        var locality_orgValue = locality_org.value.trim();
        if (locality_orgValue === '') {
            locality_orgError.textContent = 'Locality is required';
            locality_orgError.style.display = 'block';
            return false;
        } else {
            locality_orgError.style.display = 'none';
            return true;
        }
    }

    function validateOrgblock() {
        var block_orgValue = block_org.value.trim();
        if (block_orgValue === '') {
            block_orgError.textContent = 'Block is required';
            block_orgError.style.display = 'block';
            return false;
        } else {
            block_orgError.style.display = 'none';
            return true;
        }
    }

    function validateOrgplot() {
        var plot_orgValue = plot_org.value.trim();
        if (plot_orgValue === '') {
            plot_orgError.textContent = 'Plot is required';
            plot_orgError.style.display = 'block';
            return false;
        } else {
            plot_orgError.style.display = 'none';
            return true;
        }
    }

    function validateOrglandUse() {
        var landUse_orgValue = landUse_org.value.trim();
        if (landUse_orgValue === '') {
            landUse_orgError.textContent = 'Land Use is required';
            landUse_orgError.style.display = 'block';
            return false;
        } else {
            landUse_orgError.style.display = 'none';
            return true;
        }
    }

    function validateOrglandUseSubtype() {
        var landUseSubtype_orgValue = landUseSubtype_org.value.trim();
        if (landUseSubtype_orgValue === '') {
            landUseSubtype_orgError.textContent = 'Land Use SubType is required';
            landUseSubtype_orgError.style.display = 'block';
            return false;
        } else {
            landUseSubtype_orgError.style.display = 'none';
            return true;
        }
    }


    function validateOrgSaleDeedDoc() {
        if (OrgSaleDeedDoc.files.length === 0) {
            OrgSaleDeedDocError.textContent = 'This file is required';
            OrgSaleDeedDocError.style.display = 'block';
            return false;
        } else {
            var file = OrgSaleDeedDoc.files[0];
            var fileType = file.type;
            var fileName = file.name;
            var validExtension = /(\.pdf)$/i;
    
            if (!validExtension.test(fileName)) {
                OrgSaleDeedDocError.textContent = 'Only PDF files are allowed';
                OrgSaleDeedDocError.style.display = 'block';
                return false;
            } else {
                OrgSaleDeedDocError.style.display = 'none';
                return true;
            }
        }
    }

    function validateOrgBuildAgreeDoc() {
        if (OrgBuildAgreeDoc.files.length === 0) {
            OrgBuildAgreeDocError.textContent = 'This file is required';
            OrgBuildAgreeDocError.style.display = 'block';
            return false;
        } else {
            var file = OrgBuildAgreeDoc.files[0];
            var fileType = file.type;
            var fileName = file.name;
            var validExtension = /(\.pdf)$/i;
    
            if (!validExtension.test(fileName)) {
                OrgBuildAgreeDocError.textContent = 'Only PDF files are allowed';
                OrgBuildAgreeDocError.style.display = 'block';
                return false;
            } else {
                OrgBuildAgreeDocError.style.display = 'none';
                return true;
            }
        }
    }

    function validateOrgLeaseDeedDoc() {
        if (OrgLeaseDeedDoc.files.length === 0) {
            OrgLeaseDeedDocError.textContent = 'This file is required';
            OrgLeaseDeedDocError.style.display = 'block';
            return false;
        } else {
            var file = OrgLeaseDeedDoc.files[0];
            var fileType = file.type;
            var fileName = file.name;
            var validExtension = /(\.pdf)$/i;
    
            if (!validExtension.test(fileName)) {
                OrgLeaseDeedDocError.textContent = 'Only PDF files are allowed';
                OrgLeaseDeedDocError.style.display = 'block';
                return false;
            } else {
                OrgLeaseDeedDocError.style.display = 'none';
                return true;
            }
        }
    }
    function validateOrgSubMutDoc() {
        if (OrgSubMutDoc.files.length === 0) {
            OrgSubMutDocError.textContent = 'This file is required';
            OrgSubMutDocError.style.display = 'block';
            return false;
        } else {
            var file = OrgSubMutDoc.files[0];
            var fileType = file.type;
            var fileName = file.name;
            var validExtension = /(\.pdf)$/i;
    
            if (!validExtension.test(fileName)) {
                OrgSubMutDocError.textContent = 'Only PDF files are allowed';
                OrgSubMutDocError.style.display = 'block';
                return false;
            } else {
                OrgSubMutDocError.style.display = 'none';
                return true;
            }
        }
    }


    function addressOrgvalidationbeforecheck() {
        var isOrgLocalityValid = validateOrgLocality();
        var isOrgblockValid = validateOrgblock();
        var isvalidateOrgplotValid = validateOrgplot();
        var isOrglandUseValid = validateOrglandUse();
        var isOrglandUseSubtypeValid = validateOrglandUseSubtype();

        return isOrgLocalityValid && isOrgblockValid && isvalidateOrgplotValid && isOrglandUseValid && isOrglandUseSubtypeValid;
    }
// Address After Check
var localityOrgFill = document.getElementById('localityOrgFill');
var blocknoOrgFill = document.getElementById('blocknoOrgFill');
var plotnoOrgFill = document.getElementById('plotnoOrgFill');
var landUseOrgFill = document.getElementById('landUseOrgFill');
var landUseSubtypeOrgFill = document.getElementById('landUseSubtypeOrgFill');

// Error
var localityOrgFillError = document.getElementById('localityOrgFillError');
var blocknoOrgFillError = document.getElementById('blocknoOrgFillError');
var plotnoOrgFillError = document.getElementById('plotnoOrgFillError');
var landUseOrgFillError = document.getElementById('landUseOrgFillError');
var landUseSubtypeOrgFillError = document.getElementById('landUseSubtypeOrgFillError');


function validateOrglocalityFill() {
    var localityOrgFillValue = localityOrgFill.value.trim();
    if (localityOrgFillValue === '') {
        localityOrgFillError.textContent = 'Locality is required';
        localityOrgFillError.style.display = 'block';
        return false;
    } else {
        localityOrgFillError.style.display = 'none';
        return true;
    }
}

function validateOrgblocknoInvFill() {
    var blocknoOrgFillValue = blocknoOrgFill.value.trim();
    if (blocknoOrgFillValue === '') {
        blocknoOrgFillError.textContent = 'Block is required';
        blocknoOrgFillError.style.display = 'block';
        return false;
    } else {
        blocknoOrgFillError.style.display = 'none';
        return true;
    }
}

function validateOrgplotnoInvFill() {
    var plotnoOrgFillValue =plotnoOrgFill.value.trim();
    if (plotnoOrgFillValue === '') {
       plotnoOrgFillError.textContent = 'Plot is required';
       plotnoOrgFillError.style.display = 'block';
        return false;
    } else {
       plotnoOrgFillError.style.display = 'none';
        return true;
    }
}

function validateOrglandUseInvFill() {
    var landUseOrgFillValue = landUseOrgFill.value.trim();
    if (landUseOrgFillValue === '') {
        landUseOrgFillError.textContent = 'Land Use is required';
        landUseOrgFillError.style.display = 'block';
        return false;
    } else {
        landUseOrgFillError.style.display = 'none';
        return true;
    }
}

function validateOrglandUseSubtypeInvFill() {
    var landUseSubtypeOrgFillValue = landUseSubtypeOrgFill.value.trim();
    if (landUseSubtypeOrgFillValue === '') {
        landUseSubtypeOrgFillError.textContent = 'Land Use SubType is required';
        landUseSubtypeOrgFillError.style.display = 'block';
        return false;
    } else {
        landUseSubtypeOrgFillError.style.display = 'none';
        return true;
    }
}
    function addressOrgvalidationaftercheck() {
        var isOrglocalityFillValid = validateOrglocalityFill();
        var isOrgblocknoInvFillValid = validateOrgblocknoInvFill();
        var isOrgplotnoInvFillValid = validateOrgplotnoInvFill();
        var isOrglandUseInvFillValid = validateOrglandUseInvFill();
        var isOrglandUseSubtypeInvFillValid = validateOrglandUseSubtypeInvFill();

        return isOrglocalityFillValid && isOrgblocknoInvFillValid && isOrgplotnoInvFillValid && isOrglandUseInvFillValid && isOrglandUseSubtypeInvFillValid;
    }

        // Validate Form 2
        function validateForm2() {
            var isOrgNameValid = validateOrgName();
            var isOrgPANValid = validateOrgPAN();
            var iOrgNameAuthSignValid = validateOrgNameAuthSign();
            var isOrgAuthsignatoryMobileValid = validateOrgAuthsignatoryMobile();
            var isOrgEmailAuthSignValid = validateOrgEmailAuthSign();
            var isOrgAadharAuthValid = validateOrgAadharAuth();

            var isOrgSignAuthDocValid = validateOrgSignAuthDoc();

            var isOrgSaleDeedDocValid = validateOrgSaleDeedDoc();
            var isOrgBuildAgreeDocValid = validateOrgBuildAgreeDoc();
            var isOrgLeaseDeedDocValid = validateOrgLeaseDeedDoc();
            var isOrgSubMutDocValid = validateOrgSubMutDoc();
            var isOrgConsentValid = validateOrgConsent();

    
            return isOrgNameValid && isOrgPANValid && iOrgNameAuthSignValid && isOrgAuthsignatoryMobileValid && isOrgEmailAuthSignValid && isOrgAadharAuthValid && isOrgSignAuthDocValid && isOrgSaleDeedDocValid && isOrgBuildAgreeDocValid && isOrgLeaseDeedDocValid && isOrgSubMutDocValid && isOrgConsentValid;
        }


        
    form2.addEventListener('submit', function (event) {
        event.preventDefault();

        if (validateForm2() && (addressOrgvalidationbeforecheck() || addressOrgvalidationaftercheck())) {
            alert('Form submitted successfully');
            form2.submit();
        }
    });
    
    var OrgsubmitButton = document.getElementById('OrgsubmitButton');
    OrgsubmitButton.addEventListener('click', function () {
        if (validateForm2()) {
            var isYesChecked2 = document.getElementById('YesOrg').checked;
            var addressIsValidOrg = false;
    
            if (isYesChecked2) {
                addressIsValidOrg = addressOrgvalidationaftercheck();
            } else {
                addressIsValidOrg = addressOrgvalidationbeforecheck();
            }
    
            if (addressIsValidOrg) {
                form2.submit();
            }
        }
    });
})