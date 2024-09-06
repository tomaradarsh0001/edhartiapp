<div class="d-none alert alert-danger"></div>
<div class="d-none alert alert-success"></div>

<script>
    const showError = (message) => {
        if (Array.isArray(message) && message.length > 0) { //when multiple errors
            let errorListHTML = `<ul>`;
            message.forEach((listMessage, i) => {
                errorListHTML += `<li> ${listMessage} at index ${i +1 }</li>`;
            });
            errorListHTML += `</ul>`;
            $('.alert-danger').html(errorListHTML);
        } else { //when only one error
            $('.alert-danger').html(`<h6>${message}</h6>`);
        }
        $('.alert-danger').removeClass('d-none').show(); //need to add show. display none is added in div
        setTimeout(() => {
            $('.alert-danger').addClass('d-none');
        }, 3000);
    }
    const showSuccess = (message) => {
        $('.alert-success').html(`<h6>${message}</h6>`);
        $('.alert-success').removeClass('d-none');
        setTimeout(() => {
            $('.alert-success').addClass('d-none');
        }, 3000);
    }
</script><?php /**PATH C:\Users\shubh\Desktop\new 22 august\eDharti\resources\views/rgr/alert.blade.php ENDPATH**/ ?>