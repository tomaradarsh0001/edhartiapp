<div class="row mt-3 detail-view <?php echo e(isset($data) ? '': 'd-none'); ?>" id="colony-view">
    <?php if(!isset($data)): ?>
    <div class="row mb-4 d-none" id="selected-controls">
        <div class="col-lg-12">
            <button class="btn btn-danger" onclick="$(this).prop('disabled',true);generatePdfForSelectedRGR()" id="btn-selected-pdf">Generate Pdf</button>
            <button class="btn btn-primary" onclick="sendDraftForSelectedRGR()">Send Letter</button>
        </div>
    </div>
    <?php endif; ?>
    <!-- <div class="row"> -->
    <div class="col-lg-12">
        <?php echo $__env->make('modals.view-rgr-draft', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <?php if(!isset($data)): ?>
                    <th>
                        <input type="checkbox" id="check-header">
                    </th>
                    <?php endif; ?>
                    <th>Property ID</th>
                    <th>Address</th>
                    <th>Area (Sq. M.)</th>
                    <th>Land rate</th>
                    <th>Land value</th>
                    <th>RGR</th>
                    <!-- <th>circle land rate</th>
                        <th>circle land value</th>
                        <th>circle RGR</th> -->
                    <th>Calculated on</th>
                    <th>Created Date</th>
                    <?php if(!isset($data)): ?>
                    <th>Letter Sent?</th>
                    <?php endif; ?>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="colony-rows">
                <?php if(isset($data)): ?>
                <?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr <?php if(isset($highlighted) && $highlighted==$row->id): ?>
                    class="highlightedRow"
                    <?php endif; ?>>
                    <td><?php echo e($row->propertyId); ?></td>
                    <td><?php echo e($row->address); ?></td>
                    <td><?php echo e(round($row->property_area_in_sqm,2)); ?></td>
                    <?php
                    $calculationColumn = $row->calculated_on_rate == "L" ? 'lndo':'circle';
                    ?>
                    <td>
                        &#8377;<?php echo e(customNumFormat(round($row->{$calculationColumn.'_land_rate'},2))); ?>

                    </td>
                    <td>
                        &#8377;<?php echo e(customNumFormat(round($row->{$calculationColumn.'_land_value'},2))); ?>

                    </td>
                    <td>&#8377;<?php echo e(customNumFormat(round($row->{$calculationColumn.'_rgr'}))); ?>/-</td>
                    <td><?php echo e($row->calculated_on_rate == "L"?'L&DO Rate':'Circle Rate'); ?></td>
                    <td><?php echo e(date('d-m-Y',strtotime($row->created_at))); ?></td>

                    <td><a class="btn btn-draft" onclick="viewDraft(<?= $row->id ?>)"><i class="bx bx-check"></i>View Draft</a></td>

                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="9">No Data Found</td>
                </tr>
                <?php endif; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <?php if(isset($data)): ?>
        <?php echo e($data->links()); ?>

        <?php endif; ?>
    </div>
    <!-- </div> -->

</div><?php /**PATH C:\Users\shubh\Desktop\new 22 august\eDharti\resources\views/include/parts/rgr-list.blade.php ENDPATH**/ ?>