<?php if($inline): ?>

<div class="form-group row mb-4">
    <label for="<?php echo e($ref); ?>" class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><?php echo e($label); ?></label>
    <div class="col-sm-12 col-md-7">
        <select class="form-control select2 <?php echo e($class); ?>" id="<?php echo e($ref); ?>" name="<?php echo e($ref); ?>" autofocus="<?php echo e($autofocus); ?>">
            <option value="">--select--</option>
            <?php if($rows): ?>
            <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option <?php if(isset($selected) && $selected==$row->id): ?> selected <?php endif; ?> value="<?php echo e($row->id); ?>">
                <?php if(isset($row->title)): ?>
                <?php echo e($row->title); ?>

                <?php elseif(isset($row->name)): ?>
                <?php echo e($row->name); ?>

                <?php endif; ?>
            </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </select>
        <?php $__errorArgs = [$ref];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="text-danger">required</div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
</div>

<?php else: ?>

<div class="form-group">
    <label for="<?php echo e($ref); ?>"><?php echo e($label); ?></label>
    <!-- selectric -->
    <select class="form-control select2" id="<?php echo e($ref); ?>" name="<?php echo e($ref); ?>" autofocus="<?php echo e($autofocus); ?>" style="width:100%">
        <option value="">--select--</option>
        <?php if($rows): ?>
        <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option <?php if(isset($selected) && $selected==$row->id): ?> selected <?php endif; ?> value="<?php echo e($row->id); ?>">
            <?php if(isset($row->title)): ?>
            <?php echo e($row->title); ?>

            <?php elseif(isset($row->name)): ?>
            <?php echo e($row->name); ?>

            <?php endif; ?>
        </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </select>
    <?php $__errorArgs = [$ref];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
    <div class="text-danger">required</div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<?php endif; ?><?php /**PATH C:\Users\Owais\Downloads\BE\jobs\jobs\resources\views/components/combobox.blade.php ENDPATH**/ ?>