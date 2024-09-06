
<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('content'); ?>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.css" rel="stylesheet">

    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Templates</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo e($template->name); ?></li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-5">
            <form action="<?php echo e(route('templates.update', $template->id)); ?>" method="POST" class="row g-3">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="row mb-3">
                    <label for="action" class="col-sm-3 col-form-label">Action</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="action" name="action"
                            value="<?php echo e($template->action); ?>" readonly>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="input_type" class="col-sm-3 col-form-label">Type</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="input_type" name="input_type"
                            value="<?php echo e($template->type); ?>" readonly>
                    </div>
                </div>

                <div class="row mb-3" id="subjectContainer" style="display: none;">
                    <label for="subject" class="col-sm-3 col-form-label">Subject</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="subject" name="subject"
                            value="<?php echo e($template->subject); ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="template" class="col-sm-3 col-form-label">Body</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" id="summernote" name="template" rows="5" required><?php echo e($template->template); ?></textarea>
                    </div>
                </div>

                <div class="col-sm-9 offset-sm-3">
                    <button type="submit" class="btn btn-primary px-4">Save Message</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var type = $('#input_type').val();
            if (type === 'email') {
                $('#subjectContainer').show();
                $('#summernote').summernote({
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
                $('#subjectContainer').hide();
                $('#summernote').attr('rows', 5);
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footerScript'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\shubh\Desktop\new 22 august\eDharti\resources\views/communication/use.blade.php ENDPATH**/ ?>