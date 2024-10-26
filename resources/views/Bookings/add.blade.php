<x-layout-admin>
    <div class="row">
        <div class="col-12">
            <form method="post" action="{{route('store-booking')}}" id="myForm" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header border-bottom">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Add New Booking</h4>
                            </div>
                            <div class="col-md-6 text-right">
                                <?php if (has_permission(67)) { ?>
                                    <a href="{{route('bookings')}}" class="btn btn-sm btn-primary">View All</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="bl_no">BL No</label>
                                    <input type="text" id="bl_no" name="bl_no" value="{{old('bl_no')}}" class="form-control" required />
                                    @error('bl_no')
                                    <div class="text-danger">required</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <x-combobox of="locations" label="Loading Port" ref="loading_port" inline=0 />
                            </div>

                            <div class="col-md-4">
                                <x-combobox of="locations" label="Off Load" ref="off_load" inline=0 />
                            </div>



                            <div class="col-md-4">
                                <x-combobox of="parties" label="Customer" ref="customer" inline=0 />
                            </div>

                            <div class="col-md-4">
                                <x-combobox of="locations" label="Location" ref="location" inline=0 />
                            </div>
                            <div class="col-md-4">
                                <x-combobox of="job_types" label="Job Type" ref="job_type_id" inline=0 />
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="document_date">BL Date</label>
                                    <input type="date" id="date" name="date" value="{{old('date')}}" class="form-control" required />
                                    @error('document_date')
                                    <div class="text-danger">required</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="remarks">Remarks</label>
                                    <textarea class="form-control" id="remarks" name="remarks">{{old('remarks')}}</textarea>
                                </div>
                            </div>


                            <!-- <div class="col-md-4 d-none">
                                <div class="form-group">
                                    <label class="form-label" for="inputFile">Upload File:</label>
                                    <input type="file" name="files[]" id="files" class="form-control @error('files') is-invalid @enderror" accept=".xls,.xlsx,.pdf,.doc,.docx,.txt">
                                    @error('files')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div> -->
                            <!-- Additions Made -->
                            <div class="col-12">
                                <nav>
                                    <div class="nav nav-tabs nav-justified" id="nav-tab" role="tablist">
                                        <button class="nav-link active m-1" id="nav-upload-file-tab" data-bs-toggle="tab" data-bs-target="#nav-upload-file" type="button" role="tab" aria-controls="nav-upload-file" aria-selected="true">
                                            Upload File
                                        </button>
                                        <button class="nav-link m-1" id="nav-manual-entry-tab" data-bs-toggle="tab" data-bs-target="#nav-manual-entry" type="button" role="tab" aria-controls="nav-manual-entry" aria-selected="false">
                                            Manual Entry
                                        </button>
                                    </div>
                                </nav>
                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="nav-upload-file" role="tabpanel" aria-labelledby="nav-upload-file-tab">
                                        <!-- Content for Upload File -->
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label" for="inputFile">Upload File:</label>
                                                <input type="file" name="files[]" id="files" class="form-control @error('files') is-invalid @enderror" accept=".xls,.xlsx,.pdf,.doc,.docx,.txt">
                                                @error('files')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-manual-entry" role="tabpanel" aria-labelledby="nav-manual-entry-tab">
                                        <!-- Content for Manual Entry -->
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header border-bottom bg-success text-white text-center py-1">
                                                    <h4>Containers Entry</h4>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-sm">
                                                            <thead>
                                                                <tr>

                                                                    <th>Containers</th>
                                                                    <th>SIZE</th>
                                                                    <th>STATUS</th>
                                                                    <th>DATE</th>
                                                                    <th class="text-center">Loading Port</th>

                                                                    <th class="text-center">Off Load</th>
                                                                    <th class="text-center">Weight</th>
                                                                    <th class="text-center">Cross Stuffing Status</th>
                                                                    <th class="text-center">Detention Start Date</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="containers_table">
                                                                <tr>

                                                                    <td>
                                                                        <div>
                                                                            <input type="text" id="container_no_input" name="container_no-array[]" oninput="validate(this)" style="margin-left: 5px;  width:150px; height: 40px;">
                                                                            <span id="container_error" style="color: #f00;"></span>
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
                                                                                    <option value="<?= $size->container_size; ?>"><?= $size->container_size; ?></option>
                                                                            <?php }
                                                                            } ?>
                                                                        </select>

                                                                    </td>
                                                                    <td>
                                                                        <!--     Show status  -->
                                                                        <select class="form-control _select2" name="container_status-array[]" style="width:100px;">
                                                                            <option value="">--select--</option>

                                                                            <option value="full">FULL</option>
                                                                            <option value="empty">EMPTY</option>
                                                                        </select>

                                                                    </td>
                                                                    <td><input type="date" name="container_date-array[]" style="margin-left: 10px; width:100px; height: 40px;"></td>
                                                                    <td>
                                                                        <!--     Replace row with the container sizes -->
                                                                        <select class="form-control _select2" name="loading_port-array[]" style="width:100px;">
                                                                            <option value="">--select--</option>
                                                                            <?php
                                                                            if ($location) {
                                                                                foreach ($location as $loc) {
                                                                            ?>
                                                                                    <option value="<?= $loc->title; ?>"><?= $loc->title; ?></option>
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
                                                                                    <option value="<?= $loc->title; ?>"><?= $loc->title; ?></option>
                                                                            <?php }
                                                                            } ?>
                                                                        </select>

                                                                    </td>
                                                                    <td><input type="number" name="weight-array[]" style="margin-left: 10px; width:100px; height: 40px;" placeholder="Wight in KG"></td>
                                                                    <td>
                                                                        <!-- Show status  -->
                                                                        <select class="form-control _select2" name="cross_stuffing_status-array[]" style="width:100px;">
                                                                            <option value="">--select--</option>

                                                                            <option value="yes">YES</option>
                                                                            <option value="no">NO</option>
                                                                        </select>

                                                                    </td>
                                                                    <td><input type="text" name="detention_date-array[]" style="margin-left: 10px;  width:150px; height: 40px;"></td>
                                                                </tr>

                                                            </tbody>

                                                        </table>


                                                        <div class="card-footer border-top">
                                                            <div class="row">
                                                                <div class="col-12 text-right">
                                                                    <?php if (has_permission(68)) { ?>
                                                                        <button class="btn btn-primary" type="button" id="add_container_button">Add Container</button>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="col-md-12">
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-12 text-right">
                                            <?php if (has_permission(68)) { ?>
                                                <button class="btn btn-primary" type="submit">Submit</button>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>






                        </div>
                    </div>

                </div>





            </form>
        </div>
    </div>

    <?php
//echo "<pre>"; print_r($errors_report); <?php if (COUNT($errors_report)) {
    $reports = Session::get('containers_report');
    //dump($report);
    if ($reports) {
    ?>

        <div class="row">
            <div class="col-12">
                <div class="card border-danger">
                    <div class="card-header border-bottom">
                        <div class="row">
                            <div class="col-md-12">
                                <h4>
                                    Errors in Excel File Data
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm data-table">
                            <thead>
                                <tr>
                                    <th>Cell Address</th>
                                    <th>Container No</th>
                                    <th>Error Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (COUNT($reports)) {
                                    foreach ($reports as $report) {
                                ?>
                                        <tr>
                                            <td><?= $report['cell_address'] ?></td>
                                            <td><?= $report['container_no'] ?></td>
                                            <td><?= $report['message'] ?></td>
                                        </tr>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="3">
                                            <div class="alert alert-success">
                                                There is no error in your excel sheet.
                                            </div>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php }  ?>


    <!-- Bootstrap JS (make sure it's included) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js"></script>

    <script>
        var container_count = 1;
        document.getElementById('add_container_button').addEventListener('click', function(event) {
            event.preventDefault();

            var tableBody = document.getElementById('containers_table');
            var row = document.createElement('tr');

            row.innerHTML = `<td>
<div>
<input type="text" id="container_no_input_${container_count}" oninput="validate(this)" name="container_no-array[]" style="margin-left: 5px;  width:150px; height: 40px;">
<span id = "container_error_${container_count}" style = "color: #f00;"></span>
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
            <option value="<?= $size->container_size; ?>"><?= $size->container_size; ?></option>
    <?php }
    } ?>
</select>

</td>
<td>
<!--     Show status  -->
<select class="form-control _select2" name="container_status-array[]" style="width:100px;">
    <option value="">--select--</option>

    <option value="full">FULL</option>
    <option value="empty">EMPTY</option>
</select>

</td>
<td><input type="date" name="container_date-array[]" style="margin-left: 10px; width:100px; height: 40px;"></td>
<td>
<!--     Replace row with the container sizes -->
<select class="form-control _select2" name="loading_port-array[]" style="width:100px;">
    <option value="">--select--</option>
    <?php
    if ($location) {
        foreach ($location as $loc) {
    ?>
            <option value="<?= $loc->title; ?>"><?= $loc->title; ?></option>
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
            <option value="<?= $loc->title; ?>"><?= $loc->title; ?></option>
    <?php }
    } ?>
</select>

</td>
<td><input type="number" name="weight-array[]" style="margin-left: 10px; width:100px; height: 40px;" placeholder="Wight in KG"></td>
<td>
<!-- Show status  -->
<select class="form-control _select2" name="cross_stuffing_status-array[]" style="width:100px;">
    <option value="">--select--</option>

    <option value="yes">YES</option>
    <option value="no">NO</option>
</select>

</td>
<td><input type="text" name="detention_date-array[]" style="margin-left: 10px;  width:150px; height: 40px;"></td>`;

            tableBody.appendChild(row);
            container_count += 1;

        });

        document.getElementById('nav-manual-entry-tab').addEventListener('click', function() {
            //alert("Hello!");
            const form = document.getElementById('myForm');
            //form.removeAttribute();
            form.setAttribute('action', '{{route("store-booking-manually")}}')
        });

        document.getElementById('nav-upload-file-tab').addEventListener('click', function() {
            //alert("Hello!");
            const form = document.getElementById('myForm');
            //form.removeAttribute();
            form.setAttribute('action', '{{route("store-booking")}}')
        });

        function validate(element) {
            let container_no = element.value;
            let errorElement = element.nextElementSibling; // Assuming the error message span is next to the input field

            // Regex: 4 letters followed by 9 digits, no spaces
            let regex = /^[A-Za-z]{4}[0-9]{9}$/;

            if (!regex.test(container_no)) {
                errorElement.textContent = 'Booking ID must be 4 letters followed by 9 numbers with no spaces.';
                errorElement.style.display = 'inline'; // Show the error message
                //console.log("invalid");
            } else {
                errorElement.style.display = 'none'; // Hide the error message if format is correct
                //console.log("Valid");
            }
            //console.log(container_no);
        }
    </script>

</x-layout-admin>