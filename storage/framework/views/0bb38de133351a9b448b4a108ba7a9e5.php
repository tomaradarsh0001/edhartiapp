

<?php $__env->startSection('title', 'Templates'); ?>

<?php $__env->startSection('content'); ?>

    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Templates</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Message Templates</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between py-3">
                <h6 class="mb-0 text-uppercase tabular-record_font align-self-end">Templates</h6>
                <a href="<?php echo e(route('templates.create')); ?>"><button class="btn btn-primary">+ Add Template</button></a>
            </div>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Action</th>
                        <th scope="col">Type</th>
                        <th scope="col">Subject</th>
                        <th scope="col">Templates</th>
                        <th scope="col">Variables</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($template->id); ?></td>
                            <td><?php echo e($template->action); ?></td>
                            <td><?php echo e($template->type); ?></td>
                            <td><?php echo e($template->subject); ?></td>
                            <td><?php echo e(Str::limit($template->template, 50)); ?></td>
                            <td>
                                <?php
                                    preg_match_all('/\{([^}]*)\}/', $template->template, $matches);
                                    $placeholders = $matches[1];
                                ?>
                                <?php $__currentLoopData = $placeholders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $placeholder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span
                                        class="badge rounded-pill text-dark bg-light-success p-1 text-uppercase px-2 mx-1"><?php echo e($placeholder); ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </td>
                            
                            <td>
                                <?php if($template->status == 1): ?>
                                    <a href="<?php echo e(route('template.status', $template->id)); ?>">
                                        <div
                                            class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3">
                                            <i class="bx bxs-circle me-1"></i>Active
                                        </div>
                                    </a>
                                <?php else: ?>
                                    <a href="<?php echo e(route('template.status', $template->id)); ?>">
                                        <div class="badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3">
                                            <i class="bx bxs-circle me-1"></i>In-Active
                                        </div>
                                    </a>
                                <?php endif; ?>

                            </td>
                            <td>
                                <a href="<?php echo e(route('template.use', $template->id)); ?>" class="btn btn-primary px-5">Edit</a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <?php echo e($templates->links()); ?>

        </div>
    </div>
    <script>
        $(document).ready(function() {
            var table = $('#myDataTable').DataTable({
                lengthChange: false,
            });

            table.buttons().container()
                .appendTo('#myDataTable_wrapper .col-md-6:eq(0)');
        });
    </script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footerScript'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\shubh\Desktop\new 22 august\eDharti\resources\views/communication/index.blade.php ENDPATH**/ ?>