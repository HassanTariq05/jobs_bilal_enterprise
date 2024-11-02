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
    <div id="" class="row">
        <div class="col-12">
            <form method="post" action="<?php echo e(route('update-job', 26)); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="card">
                    <div class="card-header border-bottom">


                        <div class="row">
                            <div class="col-md-6">
                                <h4>Edit : &nbsp;&nbsp;&nbsp;
                                    <span class="badge badge-secondary text-white"> Booking # <?php echo e($row[0]->bl_no); ?> </span>
                                </h4>
                            </div>
                            
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="row">
                        <div class="col-md-4">
                                <div class="form-group">
                                    <label for="booking">Booking</label>
                                    <input type="text" id="booking" name="booking" value="<?php echo e($row[0]->booking); ?>" class="form-control" required/>
                                    <?php $__errorArgs = ['booking'];
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
                                    <label for="bl_no">BL No</label>
                                    <input type="text" id="bl_no" name="bl_no" value="<?php echo e($row[0]->bl_no); ?>" class="form-control"  required/>
                                    <?php $__errorArgs = ['bl_no'];
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
                                <?php if (isset($component)) { $__componentOriginal40287e078f2da5df027b9b5ca93fb61e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40287e078f2da5df027b9b5ca93fb61e = $attributes; } ?>
<?php $component = App\View\Components\Combobox::resolve(['of' => 'locations','selected' => ''.e($row[0]->loading_port).'','label' => 'Loading Port','ref' => 'loading_port','inline' => '0'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('combobox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Combobox::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40287e078f2da5df027b9b5ca93fb61e)): ?>
<?php $attributes = $__attributesOriginal40287e078f2da5df027b9b5ca93fb61e; ?>
<?php unset($__attributesOriginal40287e078f2da5df027b9b5ca93fb61e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40287e078f2da5df027b9b5ca93fb61e)): ?>
<?php $component = $__componentOriginal40287e078f2da5df027b9b5ca93fb61e; ?>
<?php unset($__componentOriginal40287e078f2da5df027b9b5ca93fb61e); ?>
<?php endif; ?>
                        </div>
                            
                        <div class="col-md-4">
                                <?php if (isset($component)) { $__componentOriginal40287e078f2da5df027b9b5ca93fb61e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40287e078f2da5df027b9b5ca93fb61e = $attributes; } ?>
<?php $component = App\View\Components\Combobox::resolve(['of' => 'locations','selected' => ''.e($row[0]->off_load).'','label' => 'Off Load','ref' => 'off_load','inline' => '0'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('combobox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Combobox::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40287e078f2da5df027b9b5ca93fb61e)): ?>
<?php $attributes = $__attributesOriginal40287e078f2da5df027b9b5ca93fb61e; ?>
<?php unset($__attributesOriginal40287e078f2da5df027b9b5ca93fb61e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40287e078f2da5df027b9b5ca93fb61e)): ?>
<?php $component = $__componentOriginal40287e078f2da5df027b9b5ca93fb61e; ?>
<?php unset($__componentOriginal40287e078f2da5df027b9b5ca93fb61e); ?>
<?php endif; ?>
                        </div>
                        


                        <div class="col-md-4">
                                <?php if (isset($component)) { $__componentOriginal40287e078f2da5df027b9b5ca93fb61e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40287e078f2da5df027b9b5ca93fb61e = $attributes; } ?>
<?php $component = App\View\Components\Combobox::resolve(['of' => 'parties','selected' => ''.e($row[0]->customer).'','label' => 'Customer','ref' => 'customer','inline' => '0'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('combobox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Combobox::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40287e078f2da5df027b9b5ca93fb61e)): ?>
<?php $attributes = $__attributesOriginal40287e078f2da5df027b9b5ca93fb61e; ?>
<?php unset($__attributesOriginal40287e078f2da5df027b9b5ca93fb61e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40287e078f2da5df027b9b5ca93fb61e)): ?>
<?php $component = $__componentOriginal40287e078f2da5df027b9b5ca93fb61e; ?>
<?php unset($__componentOriginal40287e078f2da5df027b9b5ca93fb61e); ?>
<?php endif; ?>
                        </div>
                            
                        <div class="col-md-4">
                                <?php if (isset($component)) { $__componentOriginal40287e078f2da5df027b9b5ca93fb61e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40287e078f2da5df027b9b5ca93fb61e = $attributes; } ?>
<?php $component = App\View\Components\Combobox::resolve(['of' => 'locations','selected' => ''.e($row[0]->location).'','label' => 'Location','ref' => 'location','inline' => '0'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('combobox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Combobox::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40287e078f2da5df027b9b5ca93fb61e)): ?>
<?php $attributes = $__attributesOriginal40287e078f2da5df027b9b5ca93fb61e; ?>
<?php unset($__attributesOriginal40287e078f2da5df027b9b5ca93fb61e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40287e078f2da5df027b9b5ca93fb61e)): ?>
<?php $component = $__componentOriginal40287e078f2da5df027b9b5ca93fb61e; ?>
<?php unset($__componentOriginal40287e078f2da5df027b9b5ca93fb61e); ?>
<?php endif; ?>
                        </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="document_date">Document Date</label>
                                    <input type="date" id="date" name="date" value="<?php echo e($row[0]->date); ?>" class="form-control"  required/>
                                    <?php $__errorArgs = ['document_date'];
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
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="remarks">Remarks</label>
                                    <textarea class="form-control" id="remarks" name="remarks"><?php echo e($row[0]->remarks); ?></textarea>
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
                            <div class="col-md-8">
                                <div class="form-group">
                                    <div>
                                        <label class="form-label" for="inputFile">Existing Files:</label>
                                    </div>
                                    <?php if ($file) { ?>
                                        <div class="row">
                                            <?php foreach ($file as $f) { ?>
                                                <div class="col-md-2 text-center">
                                                    <div class="text-right">
                                                        <a href="" class="fa fa-times text-danger delete-file"></a>
                                                    </div>
                                                    <div>
                                                        <a target="_blank" href="<?= getFromStorage($f->file_path); ?>">
                                                            <img src="<?= asset('assets/img/' . $f->ext . '.png'); ?>" />
                                                            
                                                        </a>
                                                    </div>
                                                    <div class="title text-center">
                                                        <?= $f->title ?>
                                                    </div>
                                                </div>

                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="remarks">Created on</label>
                                    <div><?php echo e($row[0]->created_at); ?></div>
                                </div>
                            </div> 
                        </div>
                    </div>
                    <div class="card-footer border-top">
                        <div class="row">
                            <div class="col-12 text-right">
                                <?php if (has_permission(68)) { ?>
                                    <button class="btn btn-primary" type = "submit">Submit</button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                    <!-- <div class="card-footer">
                        <div class="row">
                           <div class="col-md-12">

                                        <div class="text-right">
                                            <button class="btn btn-primary">Update</button>
                                        </div>
                                

                            </div>
                        
                        </div>
                    </div> --> 
                </div>
            </form>
          

   
    </div>
    <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Containers</h4>
                            </div>
                            
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-sm data-table" id="table-1">
                                <thead>
                                    <tr>
                                        <th width="100" class="text-center">#</th>
                                        <th>Booking</th>
                                        <th>BL No</th>
                                        <th>Container No</th>
                                        <th>Size</th>
                                        <th>Status</th>                                        
                                        <th>Vehicle No</th>
                                        <th>Trucking Mode</th>
                                        <th>Date</th>
                                        <th>Loading Port</th>
                                        <th>off Load</th>
                                        <!-- <th>Customer</th> -->
                                        <th>Remarks</th>
                                        <!-- <th width="100" class="text-center">Action</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if($containers): ?>
                                    <?php $__currentLoopData = $containers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $container): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="text-center"><?php echo e($loop->iteration); ?></td>
                                        <td><?php echo e($container->booking); ?></td>
                                        <td><?php echo e($container->bl_no); ?></td>
                                        
                                        <td><?php echo e($container->container_no); ?></td>
                                        <td><?php echo e($container->size); ?></td>
                                        <td><?php echo e($container->status); ?></td>
                                        <td><?php echo e($container->vehicle_no); ?></td>
                                        <td><?php echo e($container->trucking_mode); ?></td>
                                        <td><?php echo e($container->date); ?></td>


                                        <td><?php echo e($container->loading_port); ?></td>
                                        <td><?php echo e($container->off_loading_port); ?></td>
                                        <td><?php echo e($container->remarks); ?></td>
                                        
                                        
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    

   
    <?php $__env->startSection('exfooter'); ?>



    <?php $__env->stopSection(); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald512d371ecbc414f6bdb34c51590ff29)): ?>
<?php $attributes = $__attributesOriginald512d371ecbc414f6bdb34c51590ff29; ?>
<?php unset($__attributesOriginald512d371ecbc414f6bdb34c51590ff29); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald512d371ecbc414f6bdb34c51590ff29)): ?>
<?php $component = $__componentOriginald512d371ecbc414f6bdb34c51590ff29; ?>
<?php unset($__componentOriginald512d371ecbc414f6bdb34c51590ff29); ?>
<?php endif; ?><?php /**PATH C:\Users\Owais\Downloads\BE\jobs\jobs\resources\views/bookings/edit.blade.php ENDPATH**/ ?>