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
            <form method="post" action="<?php echo e(route('update-role-privileges', [$role->id])); ?>">
                <?php echo csrf_field(); ?>
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-12">
                                <h3 class="text-center">Privileges of Role : "<?= $role->title ?>"</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if($privileges->count()): ?>
                        <?php $__currentLoopData = $privileges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $privilege_cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="row">
                            <div class="col-12">
                                <div class="card card-primary shadow-none">
                                    <div class="card-header bg-light py-1">
                                        <h4><?php echo e($privilege_cat->title); ?></h4>
                                    </div>
                                    <div class="card-body p-2">
                                        <?php if($privilege_cat->privilege_groups->count()): ?>
                                        <?php $__currentLoopData = $privilege_cat->privilege_groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $privilege_group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="row  align-items-center mt-2">
                                            <div class="col-md-4 font-weight-bold">
                                                <?php echo e($privilege_group->title); ?>

                                            </div>
                                            <div class="col-md-8">
                                                <?php if($privilege_group->privileges->count()): ?>
                                                <div class="row">
                                                    <?php $__currentLoopData = $privilege_group->privileges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $privilege): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="col-md-3">
                                                        <div data-toggle="tooltip" data-placement="left" title="" data-original-title="<?php echo e($privilege->title); ?>  (<?php echo e($privilege->id); ?>)" class="custom-control custom-checkbox">
                                                            <input type="checkbox" <?php if (in_array($privilege->id, $role_privileges_ids)) echo "checked"; ?> name="privilege[]" class="custom-control-input" value="<?php echo e($privilege->id); ?>" id="<?php echo e($privilege->slug); ?>">
                                                            <label class="custom-control-label" for="<?php echo e($privilege->slug); ?>"><?php echo e($privilege->short_title); ?></label>
                                                        </div>
                                                    </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <hr class="my-2" />
                                            </div>
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <?php if (has_permission(146) || has_permission(147)) { ?>
                                    <button class="btn btn-primary" type="submit" name="submit">
                                        Submit
                                    </button>
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
<?php endif; ?><?php /**PATH C:\Users\Owais\Downloads\BE\jobs\jobs\resources\views/role-privileges/list.blade.php ENDPATH**/ ?>