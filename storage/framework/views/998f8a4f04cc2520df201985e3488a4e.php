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
                <div class="card-header border-bottom">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Uploaded File Information</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="<?php echo e(route('job-performance', [Request::segment(3)])); ?>" class="btn btn-sm btn-primary">View All</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                            Job #
                        </div>
                        <div class="col-sm-12 col-md-7">
                            <a target="_blank" href="<?php echo e(route('edit-job', [$row->job->id])); ?>">
                                <?= $row->job->job_no; ?>
                            </a>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                            Uploaded By
                        </div>
                        <div class="col-sm-12 col-md-7">
                            <a target="_blank" href="<?php echo e(route('edit-user', [$row->user->id])); ?>">
                                <?= $row->user->name; ?>
                            </a>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                            Uploaded On
                        </div>
                        <div class="col-sm-12 col-md-7">
                            <?= $row->created_at ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Excel Sheet Data</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?php if ($row->items->count()) { ?>
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-sm data-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <!-- <th class="text-center">Action</th> -->
                                            <th>Bill of Ladding no.</th>
                                            <th>Container no.</th>
                                            <th>Size</th>
                                            <th>Status</th>
                                            <th>Vehicle no.</th>
                                            <th>Trucking mode</th>
                                            <th>Date</th>
                                            <th>Loading Port</th>
                                            <th>Off Load</th>
                                            <th>Name</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $row->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($loop->iteration); ?></td>
                                            <!-- <td class="text-center">
                                                <input type="checkbox" aria-label="Checkbox for following text input">
                                            </td> -->
                                            <td><?php echo e($r->bl_no); ?></td>
                                            <td><?php echo e($r->container_no); ?></td>
                                            <td><?php echo e($r->size); ?></td>
                                            <td><?php echo e($r->status); ?></td>
                                            <td><?php echo e($r->vehicle_no); ?></td>
                                            <td><?php echo e($r->trucking_mode); ?></td>
                                            <td><?php echo e($r->date); ?></td>
                                            <td><?php echo e($r->loading_port); ?></td>
                                            <td><?php echo e($r->off_loading_port); ?></td>
                                            <td><?php echo e($r->party); ?></td>
                                            <td><?php echo e($r->remarks); ?></td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="alert alert-danger">
                            Sorry! records not found.
                        </div>
                    <?php } ?>
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
<?php endif; ?><?php /**PATH /Users/i2p/Downloads/jobs/jobs/resources/views/jobs/performance/show.blade.php ENDPATH**/ ?>