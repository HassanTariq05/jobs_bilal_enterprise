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
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Companies</h4>
                            </div>
                            <div class="col-md-6 text-right">
                                <?php if (has_permission(192)) { ?>
                                    <a href="<?php echo e(route('create-company')); ?>" class="btn btn-sm btn-primary">Add New</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-sm" id="table-1">
                                <thead>
                                    <tr>
                                        <th width="100" class="text-center">#</th>
                                        <th width="100">Logo</th>
                                        <th width="100">Short Name</th>
                                        <th>Title</th>
                                        <th>Address</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Contact Person</th>
                                        <th width="100" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if($rows->count()): ?>
                                    <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="text-center"><?php echo e($loop->iteration); ?></td>
                                        <td>
                                            <?php if(!empty($row->logo)): ?>
                                                <img style="width:50px;" src="<?php echo e($row->logo); ?>" />
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($row->short_name); ?></td>
                                        <td><?php echo e($row->title); ?></td>
                                        <td><?php echo e($row->address); ?></td>
                                        <td><?php echo e($row->phone); ?></td>
                                        <td><?php echo e($row->email); ?></td>
                                        <td><?php echo e($row->contact_person); ?></td>
                                        <td class="text-center">
                                            <?php if (isset($component)) { $__componentOriginale7837355806eb9c5fed48e334bc15690 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale7837355806eb9c5fed48e334bc15690 = $attributes; } ?>
<?php $component = App\View\Components\ActionBtn::resolve(['route' => 'company','id' => ''.e($row->id).'','privilegeEditId' => '193','privilegeDeleteId' => '194','privilegeRestoreId' => ''.e($row->deleted_at ? 195 : 0).''] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('action-btn'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\ActionBtn::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale7837355806eb9c5fed48e334bc15690)): ?>
<?php $attributes = $__attributesOriginale7837355806eb9c5fed48e334bc15690; ?>
<?php unset($__attributesOriginale7837355806eb9c5fed48e334bc15690); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale7837355806eb9c5fed48e334bc15690)): ?>
<?php $component = $__componentOriginale7837355806eb9c5fed48e334bc15690; ?>
<?php unset($__componentOriginale7837355806eb9c5fed48e334bc15690); ?>
<?php endif; ?>
                                            <?php /*
                                            <a href="{{route('edit-company', [$row->id])}}" class="btn btn-icon  btn-sm btn-primary"><i class="far fa-edit"></i></a>
                                            <a href="#" class="btn btn-icon  btn-sm btn-danger"><i class="fas fa-times"></i></a>
                                            */ ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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
<?php endif; ?><?php /**PATH C:\Users\Owais\Downloads\BE\jobs\jobs\resources\views/companies/list.blade.php ENDPATH**/ ?>