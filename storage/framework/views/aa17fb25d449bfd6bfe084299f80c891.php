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
                            <h4>Bookings</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            <?php if (has_permission(26)) { ?>
                                <a href="<?php echo e(route('create-booking')); ?>" class="btn btn-sm btn-primary">Add New</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="data-table table table-hover table-striped table-sm " id="table-1">
                            <thead>
                                <tr>
                                    <th width="100" class="text-center">#</th>
                                    <th>Booking</th>
                                    <th>BL No</th>
                                    <th>Loading Port</th>
                                    <th>off Load</th>
                                    <th>Customer</th>
                                    <th>Job Type</th>
                                    <th>Location</th>
                                    <th>Date</th>
                                    <th>View</th>
                                    <th class="text-center align-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($rows): ?>
                                <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="text-center"><?php echo e($loop->iteration); ?></td>
                                    <td><?php echo e($row->booking); ?></td>
                                    <td><?php echo e($row->bl_no); ?></td>
                                    <td><?php echo e($row->loading_port_name); ?></td>
                                    <td><?php echo e($row->off_load_name); ?></td>
                                    <td><?php echo e($row->customer_name); ?></td>
                                    <td><?php echo e($row->job_type_title); ?></td>
                                    <td><?php echo e($row->location_name); ?></td>
                                    <td><?php echo e($row->date); ?></td>
                                    <td>
                                        <span class="btn btn-icon btn-sm" style="padding-left: 10px" onclick="booking_container('<?php echo e($row->booking); ?>')" ;>
                                            <i class="fa fa-eye"></i>
                                        </span>
                                    </td>
                                    <td>
                                    <?php if (isset($component)) { $__componentOriginale7837355806eb9c5fed48e334bc15690 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale7837355806eb9c5fed48e334bc15690 = $attributes; } ?>
<?php $component = App\View\Components\ActionBtn::resolve(['route' => 'booking','id' => ''.e($row->id).'','privilegeEditId' => '69','privilegeDeleteId' => '70'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
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
    <!-- Modal -->

    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="booking_containers_modal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Booking Containers</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div style="overflow-x: auto;">
                        <table class="table  table-sm" id="booking_containers_table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Container No</th>
                                    <th>Size</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Loading Port</th>
                                    <th>Off Load</th>
                                    <th>Weight</th>
                                    <th>Cross Stuffing Status</th>
                                    <th>Detention Start Date</th>
                                    <th>CS input</th>
                                    <th>Ownership</th>
                                    <th>Vehicle #</th>
                                </tr>
                            </thead>
                            <tbody id="bookings_container_records">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <!-- <button type="button" onclick="update_container(row);" class="btn btn-success">Select</button>  -->
                </div>
            </div>

        </div>
    </div>
    <!--  -->
    <script>
        function booking_container(bl_no) {
            //var dataInput = $("#data_input").val(); // Get input value
            var tableBody = document.querySelector("#bookings_container_records");

            tableBody.innerHTML = "";
            // Define parameters to send
            var params = {
                '_token': $('meta[name=csrf-token]').attr('content'), // For Laravel CSRF protection
                'data': bl_no
            };

            // AJAX POST request
            $.ajax({
                url: 'http://localhost:8000/bookings/get-booking-containers', // URL to send the request to
                type: 'POST', // Request type (GET, POST, etc.)
                data: params, // Data to send
                success: function(response) {
                    // Parse the JSON response
                    // let table = $('#booking_containers_table').DataTable();
                    // table.clear();
                    // let tableBody = document.getElementById('bookings_container_records')
                    let parsedResponse = JSON.parse(response);
                    console.log(parsedResponse)
                    // Iterate through each item in the parsed response
                    let num = 0
                    // Iterate over the response array
                    parsedResponse.forEach(function(data) {
                        // Create a new row
                        let row = document.createElement('tr');
                        let cross_input = "";
                        if (data.cross_stuffing_status == "yes") {
                            cross_input += `<input type = "text" id = "cross_input_container_${num}" style = "width:100px; height:40px;"></input>`
                        } else {
                            cross_input += `<input type = "text" id = "cross_input_container_${num}" style = "width:100px; height:40px;" disabled></input>`

                        }
                        // Append table data cells with each value
                        row.innerHTML = `
                            <td>${data.container_no}</td>
                            <td>${data.size}</td>
                            <td>${data.status}</td>
                            <td>${data.date}</td>
                            <td>${data.loading_port}</td>
                            <td>${data.off_loading_port}</td>
                            <td>${data.container_weight}</td>
                            <td>${data.cross_stuffing_status}</td>
                            <td>${data.detention_start_date}</td>
                            <td>${cross_input}</td>
                            <td>
                            <select class="form-control _select2" id = "ownership_contianer_${num}" style="width:100px;" onchange = "assign_vehicle(this)">
                                <option value="">--select--</option>
                                <option value="1">Owned</option>
                                <option value="0">Private</option>
                                                                                                                            
                            </select>                            
                            </td>
                
                            `;
                        row.setAttribute('container_id', data.id)
                        // Append the row to the table body
                        tableBody.appendChild(row);
                        num++
                    });
                    $('#booking_containers_modal').modal('show');

                },

                error: function(xhr, status, error) {
                    // Handle error response
                    console.log("error " + error + "status " + status + "xhr " + xhr)

                }
            });

        }

        function assign_vehicle(selected_ownership) {
            // ownership is the individal table data element
            let vehicle_no
            let container = selected_ownership.closest('tr')
            let container_id = container.getAttribute('container_id')
            let num_value = selected_ownership.id.split('_').pop(); // Get the last part after "_"
            const vehicle_no_input = document.getElementById(`vehicle_no_container_${num_value}`);

            // let result = text.substr(text.length-1, 1);

            console.log(selected_ownership)
            console.log(selected_ownership.value)
            console.log(container_id)
            console.log("NUM VALUE " + num_value)
            if (vehicle_no_input) {
                const vehicle_td = vehicle_no_input.closest('td');
                vehicle_td.remove();
            }

            if (selected_ownership.value == "1") {
                vehicle_no = `<td><input id = "vehicle_no_container_${num_value}" style = "height:40px" type = "text" oninput = "validate_vehicle(this)" placeholder = "Input for Owned"></input></td>`
            } else {
                vehicle_no = `<td><input id = "vehicle_no_container_${num_value}" style = "height:40px" type = "text" oninput = "validate_vehicle(this)"  placeholder = "Input for private"></input></td>`

            }
            container.innerHTML += vehicle_no
        }

        function validate_vehicle(vehicle_date) {
            let vehicle_no = vehicle_date.value
            console.log("Vehicle No " + vehicle_no)
        }
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald512d371ecbc414f6bdb34c51590ff29)): ?>
<?php $attributes = $__attributesOriginald512d371ecbc414f6bdb34c51590ff29; ?>
<?php unset($__attributesOriginald512d371ecbc414f6bdb34c51590ff29); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald512d371ecbc414f6bdb34c51590ff29)): ?>
<?php $component = $__componentOriginald512d371ecbc414f6bdb34c51590ff29; ?>
<?php unset($__componentOriginald512d371ecbc414f6bdb34c51590ff29); ?>
<?php endif; ?><?php /**PATH /Users/i2p/Downloads/jobs/jobs/resources/views/bookings/list.blade.php ENDPATH**/ ?>