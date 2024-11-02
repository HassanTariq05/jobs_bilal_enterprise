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
                                <h4>Job Performance Excel Sheets</h4>
                            </div>
                            <div class="col-md-6 text-right">
                                <a href="<?php echo e(route('edit-job', [Request::segment(3)])); ?>" class="btn btn-sm btn-dark">View Job</a>
                                <a href="<?php echo e(route('create-job-performance', [Request::segment(3)])); ?>" class="btn btn-sm btn-primary">Add New</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-sm data-table" id="table-1">
                                <thead>
                                    <tr>
                                        <th width="100" class="text-center">#</th>
                                        <th>Uploaded By</th>
                                        <th>Uploaded On</th>
                                        <th>File Name</th>
                                        <th width="100" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if($rows->count()): ?>
                                    <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($loop->iteration); ?></td>
                                        <td><?php echo e($row->user->name); ?></td>
                                        <td><?php echo e($row->created_at); ?></td>
                                        <td><?php echo e($row->file_temp_name); ?></td>
                                        <td class="text-center">
                                            <a href="<?php echo e(route('show-job-performance', [request()->segment(3) ,$row->id])); ?>" data-toggle="tooltip" data-placement="left" title="" data-original-title="View Sheet Data" class='btn btn-icon  btn-sm btn-primary'>
                                                <i class="far fa-eye"></i>
                                            </a>
                                            <?php /*
                                            <a class='btn btn-icon btn-sm btn-danger text-white' data-toggle="tooltip" data-placement="left" title="" data-original-title="Delete Record">
                                                <i class="fas fa-times"></i>
                                            </a>
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
<?php endif; ?>
<?php /**PATH /Users/i2p/Downloads/jobs/jobs/resources/views/jobs/performance/list.blade.php ENDPATH**/ ?>