<div class="row g-3">

    <div class="col-12 col-lg-3">
        <label for="colonyName" class="form-label">Colony Name (Present)</label>
        <select class="form-control selectpicker" data-live-search="true" name="colony_id" id="colony_id" aria-label="Colony Name (Present)">
            <option value="">Select</option>
            <?php $__currentLoopData = $colonies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $colony): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($colony->id); ?>"><?php echo e($colony->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <?php $__errorArgs = ['colony_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <span class="errorMsg"><?php echo e($message); ?></span>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        <div id="colonyIdError" class="text-danger"></div>
    </div>

    <div class="col-12 col-lg-3">
        <label for="LandType" class="form-label">Block</label>
        <select class="form-control selectpicker" id="block" name="block" aria-label="Default select example">
            <option value="">Select Block</option>

        </select>
        <?php $__errorArgs = ['block'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <span class="errorMsg"><?php echo e($message); ?></span>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        <div id="blockError" class="text-danger"></div>
    </div>

    <div class="col-12 col-lg-3">
        <label for="LandType" class="form-label">Plot No./Flat No.</label>
        <select class=" form-control selectpicker" id="plot" name="plot" aria-label="Default select example">
            <option value="">Select Plot/Flat</option>

        </select>
        <?php $__errorArgs = ['plot'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <span class="errorMsg"><?php echo e($message); ?></span>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        <div id="plotError" class="text-danger"></div>
    </div>
    <div class="col-12 col-lg-1 text-center">
        <h5 class="mt-4">OR</h5>

    </div>
    <div class="col col-lg-2">
        <label for="oldPropertyId" class="form-label">Search By Property Id</label>
        <input type="text" name="oldPropertyId" id="oldPropertyId" class="form-control" placeholder="Enter property id">
    </div>
</div><!---end row-->
<!-- <script src="<?php echo e(asset('assets/js/bootstrap-select.min.js')); ?>"></script> -->
<script>
    var selectedColonyId;
    var leaseHoldOnly = <?= isset($leaseHoldOnly) ?>;
    $('#colony_id').change(function() {
        selectedColonyId = $(this).val();
        var targetSelect = $('#block')
        targetSelect.html('<option>Select a Block</option>');
        targetSelect.selectpicker('refresh');
        var reponseUrl = leaseHoldOnly ? "<?php echo e(url('/rgr/blocks-in-colony')); ?>" + '/' + selectedColonyId + '/' + 1 : "<?php echo e(url('/rgr/blocks-in-colony')); ?>" + '/' + selectedColonyId
        if (selectedColonyId != "") {
            $.ajax({ // call for subtypes for selected property types
                url: reponseUrl,
                type: "get",
                success: function(res) {
                    if (leaseHoldOnly && res.length == 0) {
                        alert('No lease hold property found in the selected colony');
                    }
                    $.each(res, function(key, value) {

                        var newOption = $('<option>', {
                            value: value.block_no ?? "null",
                            text: value.block_no ?? 'Not Applicable'
                        });
                        targetSelect.append(newOption);
                    });
                    targetSelect.selectpicker('refresh');
                }
            });
        }
    })
    $('#block').change(function() {
        var selectedBlock = $(this).val();
        var targetSelect = $('#plot')
        targetSelect.html('<option>Select a Property</option>')
        if (selectedColonyId != "") {
            var reponseUrl = leaseHoldOnly ? "<?php echo e(url('/rgr/properties-in-block')); ?>" + '/' + selectedColonyId + '/' + selectedBlock + '/' + 1 : "<?php echo e(url('/rgr/properties-in-block')); ?>" + '/' + selectedColonyId + '/' + selectedBlock
            console.log(reponseUrl);
            $.ajax({ // call for subtypes for selected property types
                url: reponseUrl,
                type: "get",
                success: function(res) {

                    $.each(res, function(key, value) {
                        var newOption = $('<option>', {
                            value: (value.is_joint_property !== undefined) ? value.old_propert_id : value.property_master_id + '_' + value.id, // if not splited then old property id else parentPropertyId_splitedPropertyId
                            text: value.plot_or_property_no ?? value.plot_flat_no
                        });
                        targetSelect.append(newOption);
                    });
                    targetSelect.selectpicker('refresh');

                }
            });
        }
    });
</script><?php /**PATH C:\Users\shubh\Desktop\new 22 august\eDharti\resources\views/include/parts/property-selector.blade.php ENDPATH**/ ?>