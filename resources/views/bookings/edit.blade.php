<x-layout-admin>
    <div id="" class="row">
        <div class="col-12">
            <form method="post" action="{{route('update-job', 26)}}" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header border-bottom">


                        <div class="row">
                            <div class="col-md-6">
                                <h4>Edit : &nbsp;&nbsp;&nbsp;
                                    <span class="badge badge-secondary text-white">{{$row[0]->bl_no}} </span>
                                </h4>
                            </div>
                            <div class="col-md-6 text-align-right">
                                <h4>Created : &nbsp;&nbsp;&nbsp;
                                    <span class="">{{ date('d/m/Y h:i A', strtotime($row[0]->created_at)) }} </span>
                                </h4>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="row">
                        <div class="col-md-4">
                                <div class="form-group">
                                    <label for="booking">Booking</label>
                                    <input type="text" id="booking" name="booking" value="{{$row[0]->booking}}" class="form-control" required/>
                                    @error('booking')
                                    <div class="text-danger">required</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="bl_no">BL No</label>
                                    <input type="text" id="bl_no" name="bl_no" value="{{$row[0]->bl_no}}" class="form-control"  required/>
                                    @error('bl_no')
                                    <div class="text-danger">required</div>
                                    @enderror
                                </div>
                            </div>
                        <div class="col-md-4">
                                <x-combobox of="locations"  selected="{{$row[0]->loading_port}}" label="Loading Port" ref="loading_port" inline=0 />
                        </div>
                            
                        <div class="col-md-4">
                                <x-combobox of="locations"   selected="{{$row[0]->off_load}}"  label="Off Load" ref="off_load" inline=0 />
                        </div>
                        


                        <div class="col-md-4">
                                <x-combobox of="parties"   selected="{{$row[0]->customer}}"  label="Customer" ref="customer" inline=0 />
                        </div>
                            
                        <div class="col-md-4">
                                <x-combobox of="locations"  selected="{{$row[0]->location}}" label="Location" ref="location" inline=0 />
                        </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="document_date">Document Date</label>
                                    <input type="date" id="date" name="date" value="{{$row[0]->date}}" class="form-control"  required/>
                                    @error('document_date')
                                    <div class="text-danger">required</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="remarks">Remarks</label>
                                    <textarea class="form-control" id="remarks" name="remarks">{{$row[0]->remarks}}</textarea>
                                </div>
                            </div>
                           <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label" for="inputFile">Upload File:</label>
                                    <input type="file" name="files[]" id="files" class="form-control @error('files') is-invalid @enderror" accept=".xls,.xlsx,.pdf,.doc,.docx,.txt">
                                    @error('files')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
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
                                    <div>{{$row[0]->created_at}}</div>
                                </div>
                            </div> 
                        </div>
                    </div>
                    <div class="card-footer border-top">
                        <div class="row">
                            <div class="col-12 text-right">
                                <?php if (has_permission(256)) { ?>
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
                    <form method="post" action="{{route('update-containers-manually')}}" id="containers-form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="booking" value="{{$row[0]->booking}}"/>
                    <input type="hidden" name="bl_no" value="{{$row[0]->bl_no}}"/>
                    <div class="card-body p-0">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Container#</th>
                                            <th>SIZE</th>
                                            <th>STATUS</th>
                                            <th>DATE</th>
                                            <th class="text-center">Loading Port</th>
                                            <th class="text-center">Off Load</th>
                                            <th class="text-center">Weight</th>
                                            <th class="text-center">Cross Stuffing Status</th>
                                            <th class="text-center">Detention Start Date</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="containers_table">
                                        @if($containers)
                                        {{$i=0}}
                                        @foreach($containers as $container)
                                        <tr id="container_row_{{$i}}">
                                            <td>
                                                <div>
                                                    <input 
                                                        type="text" 
                                                        id="container_no_input_0" 
                                                        name="container_no-array[]" 
                                                        oninput="validateContainer(this)" 
                                                        style="margin-left: 5px; width:150px; height: 40px;"
                                                        value="{{$container->container_no}}"
                                                        pattern="^[A-Za-z]{4}[0-9]{7}$"
                                                    >
                                                </div>
                                            </td>

                                            <td>
                                                <!--     Replace row with the container sizes -->
                                                <select class="form-control _select2" name="container_size-array[]" style="width:100px;">
                                                    <option value="">--select--</option>
                                                    <?php
                                                    if ($container_sizes) {
                                                        foreach ($container_sizes as $size) {
                                                    ?>
                                                            <option value="<?= $size->container_size; ?>" {{$container->size ==$size->container_size ? "selected" : "" }}><?= $size->container_size; ?></option>
                                                    <?php }
                                                    } ?>
                                                </select>

                                            </td>
                                            <td>
                                                <!--     Show status  -->
                                                <select class="form-control _select2" name="container_status-array[]" style="width:100px;">
                                                    <option value="">--select--</option>

                                                    <option value="full" {{strcasecmp($container->status, "FULL") == 0 ? "selected" : "" }}>FULL</option>
                                                    <option value="empty" {{strcasecmp($container->status, "EMPTY") == 0 ? "selected" : "" }}>EMPTY</option>
                                                </select>

                                            </td>
                                            <td><input type="date" name="container_date-array[]" style="margin-left: 10px; width:100px; height: 40px;" value="{{$container->date}}"></td>
                                            <td>
                                                <!--     Replace row with the container sizes -->
                                                <select class="form-control _select2" name="loading_port-array[]" style="width:100px;">
                                                    <option value="">--select--</option>
                                                    <?php
                                                    if ($location) {
                                                        foreach ($location as $loc) {
                                                    ?>
                                                            <option value="<?= $loc->title; ?>" {{$container->loading_port == $loc->title ? "selected" : "" }}><?= $loc->title; ?></option>
                                                    <?php }
                                                    } ?>
                                                </select>

                                            </td>

                                            <td>
                                                <!--     Replace row with the container sizes -->
                                                <select class="form-control _select2" name="off_load-array[]" style="width:100px;">
                                                    <option value="">--select--</option>
                                                    <?php
                                                    if ($location) {
                                                        foreach ($location as $loc) {
                                                    ?>
                                                            <option value="<?= $loc->title; ?>" {{$container->off_loading_port == $loc->title ? "selected" : "" }}><?= $loc->title; ?></option>
                                                    <?php }
                                                    } ?>
                                                </select>

                                            </td>
                                            <td><input type="number" name="weight-array[]" style="margin-left: 10px; width:100px; height: 40px;" placeholder="Wight in KG" value="{{$container->container_weight}}"></td>
                                            <td>
                                                <!-- Show status  -->
                                                <select class="form-control _select2" name="cross_stuffing_status-array[]" style="width:100px;">
                                                    <option value="">--select--</option>

                                                    <option value="yes" {{$container->cross_stuffing_status == "yes" ? "selected" : ""}} >YES</option>
                                                    <option value="no" {{$container->cross_stuffing_status == "no" ? "selected" : ""}}>NO</option>
                                                </select>

                                            </td>
                                            <td><input type="date" name="detention_date-array[]" style="margin-left: 10px;  width:150px; height: 40px;" value="{{$container->detention_start_date}}"></td>
                                            <td>
                                                <div class="delete_manual_container" data=`+(container_count)+` onclick="if(confirm('Are you sure you want to delete this?')) deleteRow({{$i++}})" >
                                                    <i class="fas fa-trash"></i>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>

                                </table>
                                <div class="card-footer border-top">
                                    <div class="row">
                                        <div>
                                        <span class="container_error" id="validation_line" style="color: #f00; display: none;"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-right">
                                <?php if (has_permission(253)) { ?>
                                    <button class="btn btn-success" type="button" id="add_container_button">+ Add Container</button>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-12 text-right">
                                        <?php if (has_permission(253)) { ?>
                                            <button id="submit_button" class="btn btn-primary" type="submit">Save Containers</button>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    

   
    @section('exfooter')



    @endsection

</x-layout-admin>

<script>

    var container_count = {{count($containers)}};
    document.getElementById('add_container_button').addEventListener('click', function(event) {
        event.preventDefault();

        var tableBody = document.getElementById('containers_table');
        var row = document.createElement('tr');
        row.setAttribute('id', 'container_row_'+container_count)
        row.innerHTML = 
        `<td>
            <div>
                <input type="text" id="container_no_input_${container_count}" oninput="validateContainer(this)" name="container_no-array[]" style="margin-left: 5px; width:150px; height: 40px;" pattern="^[A-Za-z]{4}[0-9]{7}$">
                <span class="container_error" style="color: #f00; display: none;"></span>
            </div>
        </td>
        <td>
            <select class="form-control _select2" name="container_size-array[]" style="width:100px;">
                <option value="">--select--</option>
                <?php
                if ($container_sizes) {
                    foreach ($container_sizes as $size) {
                        echo "<option value=\"{$size->container_size}\">{$size->container_size}</option>";
                    }
                }
                ?>
            </select>
        </td>
        <td>
            <select class="form-control _select2" name="container_status-array[]" style="width:100px;">
                <option value="">--select--</option>
                <option value="full">FULL</option>
                <option value="empty">EMPTY</option>
            </select>
        </td>
        <td><input type="date" name="container_date-array[]" style="margin-left: 10px; width:100px; height: 40px;"></td>
        <td>
            <select class="form-control _select2" name="loading_port-array[]" style="width:100px;">
                <option value="">--select--</option>
                <?php
                if ($location) {
                    foreach ($location as $loc) {
                        echo "<option value=\"{$loc->title}\">{$loc->title}</option>";
                    }
                }
                ?>
            </select>
        </td>
        <td>
            <select class="form-control _select2" name="off_load-array[]" style="width:100px;">
                <option value="">--select--</option>
                <?php
                if ($location) {
                    foreach ($location as $loc) {
                        echo "<option value=\"{$loc->title}\">{$loc->title}</option>";
                    }
                }
                ?>
            </select>
        </td>
        <td><input type="number" name="weight-array[]" style="margin-left: 10px; width:100px; height: 40px;" placeholder="Weight in KG"></td>
        <td>
            <select class="form-control _select2" name="cross_stuffing_status-array[]" style="width:100px;">
                <option value="">--select--</option>
                <option value="yes">YES</option>
                <option value="no">NO</option>
            </select>
        </td>
        <td><input type="date" name="detention_date-array[]" style="margin-left: 10px;  width:150px; height: 40px;"></td>
        <td>
            <div class="delete_manual_container" data=`+(container_count)+` onclick="if(confirm('Are you sure you want to delete this?')) deleteRow(`+container_count+`)" >
                <i class="fas fa-trash"></i>
            </div>
        </td>`;

        tableBody.appendChild(row);
        container_count += 1;
    });

    function deleteRow(counter) {
        var row = document.getElementById('container_row_'+counter);
        row.parentNode.removeChild(row);
    }

    $(".btn-primary").click(function() {
        setTimeout(() => {
            $(this).removeClass('btn-progress');
        }, 1000)
    });

</script>