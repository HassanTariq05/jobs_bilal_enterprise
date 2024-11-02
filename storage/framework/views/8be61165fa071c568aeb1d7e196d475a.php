<?php if (isset($component)) { $__componentOriginald512d371ecbc414f6bdb34c51590ff29 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald512d371ecbc414f6bdb34c51590ff29 = $attributes; } ?>
<?php $component = App\View\Components\LayoutAdmin::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layout-admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\LayoutAdmin::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="row">
        <div class="col-12">
            <form method="post" action="<?php echo e(route('store-job-invoice', [$id])); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="card">
                    <div class="card-header border-bottom">
                        <h4>Add Invoice For : <span class="badge badge-secondary text-white"> Job # <?php echo e($job->job_no); ?> </span></h4>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="job_id" value="<?php echo e($id); ?>" />
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="party_id">Customer</label>
                                    <select class="form-control select2" id="party_id" name="party_id">
                                        <option value="">--select--</option>
                                        <?php if($customers): ?>
                                        <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($customer->id); ?>"><?php echo e($customer->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                                    <?php $__errorArgs = ['party_id'];
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="inv_date">Invoice Date</label>
                                    <input id="inv_date" type="date" class="form-control" name="inv_date">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label" for="inputFile">Upload File:</label>
                                    <input type="file" name="files[]" id="files" class="form-control <?php $__errorArgs = ['files'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" accept=".xls,.xlsx,.pdf,.doc,.docx,.txt">
                                    <?php $__errorArgs = ['files'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer border-top">
                        <div class="row">
                            <div class="col-12 text-right">
                                <?php if (has_permission(80)) { ?>
                                    <button class="btn btn-primary">Submit</button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald512d371ecbc414f6bdb34c51590ff29)): ?>
<?php $attributes = $__attributesOriginald512d371ecbc414f6bdb34c51590ff29; ?>
<?php unset($__attributesOriginald512d371ecbc414f6bdb34c51590ff29); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald512d371ecbc414f6bdb34c51590ff29)): ?>
<?php $component = $__componentOriginald512d371ecbc414f6bdb34c51590ff29; ?>
<?php unset($__componentOriginald512d371ecbc414f6bdb34c51590ff29); ?>
<?php endif; ?><?php /**PATH C:\Users\Owais\Downloads\BE\jobs\jobs\resources\views/jobs/invoice/add.blade.php ENDPATH**/ ?>