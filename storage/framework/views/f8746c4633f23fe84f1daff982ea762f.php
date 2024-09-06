     <div class="modal fade" id="draftModal" tabindex="-1" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered modal-xl">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title">View Revised Ground Rent Draft</h5>
                 </div>
                 <div class="modal-body">
                 </div>
                 <div class="modal-footer">
                     <button onclick="saveAsPdf()" class="btn btn-primary" id="btn-pdf">Generate pdf</button>
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn-close">Close</button>
                 </div>
             </div>
         </div>
     </div>

     <script>
         let rgrId;

         function viewDraft(id) {
             rgrId = id;
             let url = "<?php echo e(url('/rgr/view-draft')); ?>" + '/' + rgrId;
             $('.modal-body').load(url, function() {

                 if ($('#pdf-path').length > 0) {
                     let padfPath = $('#pdf-path').val();
                     if (padfPath) { //disable generate pdf button if pdf path is found
                         $("#btn-pdf").prop('disabled', true);
                     } else {
                         $("#btn-pdf").prop('disabled', false);
                     }
                 } else {
                     $("#btn-pdf").prop('disabled', false);
                 }

             });
             $('#draftModal').modal('show')

         }

         function saveAsPdf() {
             $.ajax({
                 type: "get",
                 url: "<?php echo e(url('rgr/save-as-pdf')); ?>" + '/' + rgrId,
                 success: function(response) {
                     setTimeout(function() {
                         $('#draftModal').modal('hide') //fixed
                         //  $('#btn-close').click(); //workaround - for some reason $('#draftModal').modal('hide'); not working. reason unknown for now.
                     }, 20);
                     if (response.status == 'error') {
                         showError(response.details)
                     }
                     if (response.status == 'success') {
                         showSuccess(response.message);
                     }
                 },
                 error: response => {
                     console.log(response)
                 }

             })
         }
     </script><?php /**PATH C:\Users\shubh\Desktop\new 22 august\eDharti\resources\views/modals/view-rgr-draft.blade.php ENDPATH**/ ?>