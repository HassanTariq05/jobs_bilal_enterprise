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
                                <h4>Journal Voucher</h4>
                            </div>
                            <div class="col-md-6 text-right">
                                <?php // if (has_permission(156)) { 
                                ?>
                                <a href="<?php echo e(route('create-journal-voucher')); ?>" class="btn btn-sm btn-primary">Add New</a>
                                <?php // } 
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <?php
                        //echo "<pre>"; print_r($rows);
                        ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-sm data-table" id="table-1">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Voucher #</th>
                                        <th>Voucher Type</th>
                                        <th>Date</th>
                                        <th>Cheque No</th>
                                        <th>Cheque Date</th>
                                        <th width="100" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if($rows->count()): ?>
                                    <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="text-center"><?php echo e($loop->iteration); ?></td>
                                        <td><?php echo e($row->voucher_no); ?></td>
                                        <td><?php echo e($row->voucher_type->title); ?></td>
                                        <td><?php echo e($row->date); ?></td>
                                        <td><?php echo e($row->cheque_no); ?></td>
                                        <td><?php echo e($row->cheque_date); ?></td>
                                        <td>
                                            <?php if (isset($component)) { $__componentOriginale7837355806eb9c5fed48e334bc15690 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale7837355806eb9c5fed48e334bc15690 = $attributes; } ?>
<?php $component = App\View\Components\ActionBtn::resolve(['route' => 'journal-voucher','id' => ''.e($row->id).''] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
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
<?php endif; ?><?php /**PATH /Users/i2p/Downloads/jobs/jobs/resources/views/journal-vouchers/list.blade.php ENDPATH**/ ?>