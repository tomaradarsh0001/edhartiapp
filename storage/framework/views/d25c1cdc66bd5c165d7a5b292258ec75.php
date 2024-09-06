

<?php $__env->startSection('title', 'Templates'); ?>

<?php $__env->startSection('content'); ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.css" rel="stylesheet">

    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Templates</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create Template</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card p-3">
        <div class="card-body">
            <form action="<?php echo e(route('templates.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="mb-3">
                    <label for="type">Type</label>
                    <select name="type" id="type" class="form-control" required>
                        <option value="" disabled selected>Select type</option>
                        <option value="sms">SMS</option>
                        <option value="whatsapp">WhatsApp</option>
                        <option value="email">Email</option>
                    </select>
                </div>
                <div class="mb-3" id="subjectContainer" style="display: none;">
                    <label for="subject" class="form-label">Subject</label>
                    <input type="text" class="form-control" id="subject" name="subject">
                </div>
                <div class="mb-3">
                    <label for="action" class="form-label">Action</label>
                    <input type="text" class="form-control" id="action" name="action" required>
                </div>
                <div class="mb-3">
                    <label for="template" class="form-label">Template</label>
                    <textarea class="form-control" id="template" name="template" rows="3" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Save Template</button>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footerScript'); ?>
    <script>
        $(document).ready(function() {
            $('#type').change(function() {
                var subjectContainer = $('#subjectContainer');
                if ($(this).val() === 'email') {
                    subjectContainer.show();
                    $('#template').summernote({
                        height: 200,
                        toolbar: [
                            ['style', ['bold', 'italic', 'underline', 'clear']],
                            ['font', ['strikethrough', 'superscript', 'subscript']],
                            ['color', ['color']],
                            ['para', ['ul', 'ol', 'paragraph']],
                            ['height', ['height']],
                            ['insert', ['link', 'picture', 'video', 'hr']],
                            ['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']]
                        ],
                    });
                } else {
                    subjectContainer.hide();
                    if ($('#template').next('.note-editor').length) {
                        $('#template').summernote('destroy');
                    }
                    $('#template').attr('rows', 3);
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\shubh\Desktop\new 22 august\eDharti\resources\views/communication/create.blade.php ENDPATH**/ ?>