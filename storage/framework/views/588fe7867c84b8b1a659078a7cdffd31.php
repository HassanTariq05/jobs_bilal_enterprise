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
                                <h4>Parties</h4>
                            </div>
                            <div class="col-md-6 text-right">
                                <?php if (has_permission(198)) { ?>
                                    <a href="<?php echo e(route('create-party')); ?>" class="btn btn-sm btn-primary">Add New</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">

                        <?php if (count($rows) > 0) { ?>

                            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                <?php
                                $c = 1;
                                foreach ($rows as $party_type) {
                                    if ($c < 2) {
                                        $class = 'active';
                                    } else {
                                        $class = '';
                                    }
                                ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?= $class ?>" id="<?= $party_type->slug ?>-tab2" data-toggle="tab" href="#<?= $party_type->slug ?>" role="tab" aria-controls="<?= $party_type->slug ?>" aria-selected="true">
                                            <?= $party_type->title ?>
                                        </a>
                                    </li>
                                <?php $c++;
                                }
                                ?>
                            </ul>
                            <div class="tab-content tab-bordered">

                                <?php
                                $c = 1;
                                foreach ($rows as $party_type) {
                                    if ($c < 2) {
                                        $class = 'active';
                                    } else {
                                        $class = '';
                                    }
                                ?>

                                    <div class="tab-pane fade show <?= $class ?>" id="<?= $party_type->slug ?>" role="tabpanel" aria-labelledby="<?= $party_type->slug ?>-tab2">
                                        <div class="h5"><?= $party_type->title ?> List</div>
                                        <div class="table-responsive">
                                            <table class="table table-hover table-striped table-sm data-table" id="table-1">
                                                <thead>
                                                    <tr>
                                                        <th width="100" class="text-center">#</th>
                                                        <th width="150">Short Name</th>
                                                        <th>Title</th>
                                                        <th>Address</th>
                                                        <th>Contact</th>
                                                        <th>Email</th>
                                                        <th>Contact Person</th>
                                                        <th>Bank Name</th>
                                                        <th>IBAN</th>
                                                        <th width="100" class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if($party_type->parties): ?>
                                                    <?php $__currentLoopData = $party_type->parties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                    <td class="text-center"><?php echo e($loop->iteration); ?></td>
                                                        <td><?php echo e($row->short_name); ?></td>
                                                        <td><?php echo e($row->title); ?></td>
                                                        <td><?php echo e($row->address); ?></td>
                                                        <td><?php echo e($row->contact); ?></td>
                                                        <td><?php echo e($row->email); ?></td>
                                                        <td><?php echo e($row->contact_person); ?></td>
                                                        <td><?php echo e($row->bank_name); ?></td>
                                                        <td><?php echo e($row->iban); ?></td>
                                                        <td class="text-center">
                                                            <?php if (isset($component)) { $__componentOriginale7837355806eb9c5fed48e334bc15690 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale7837355806eb9c5fed48e334bc15690 = $attributes; } ?>
<?php $component = App\View\Components\ActionBtn::resolve(['route' => 'party','id' => ''.e($row->id).'','privilegeEditId' => '199','privilegeDeleteId' => '200','privilegeRestoreId' => ''.e($row->deleted_at ? 201 : 0).''] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
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
                                                            <a href="{{route('edit-party', [$row->id])}}" class="btn btn-icon  btn-sm btn-primary"><i class="far fa-edit"></i></a>
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

                                <?php $c++;
                                }
                                ?>


                            </div>




                        <?php } else { ?>
                            <div class="alert alert-danger">
                                Records not found.
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
<?php endif; ?><?php /**PATH /Users/i2p/Downloads/jobs/jobs/resources/views/parties/list.blade.php ENDPATH**/ ?>