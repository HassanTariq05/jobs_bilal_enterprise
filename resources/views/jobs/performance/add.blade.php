<x-layout-admin>

    <div class="row">
        <div class="col-12">
            <form method="post" action="{{route('upload-job-performance-sheet', [Request::segment(3)])}}" enctype='multipart/form-data'>
                @csrf
                <div class="card">
                    <div class="card-header border-bottom">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>
                                    Upload CSV File
                                </h4>
                            </div>
                            <div class="col-md-6 text-right">
                                <a href="{{route('job-performance', [Request::segment(3)])}}" class="btn btn-sm btn-primary">View All</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                                Helpfull Downlods
                            </div>
                            <div class="col-sm-12 col-md-7">
                                <a href="{{asset('assets/job_performance_sample.xlsx')}}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Download Sample File" class="btn btn-primary m-2">
                                    Data Sample File
                                </a>
                                <a href="{{route('download-locations-master', [Request::segment(3)])}}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Download Location Master File" class="btn btn-info m-2">
                                    Location Master File
                                </a>
                                <a href="{{route('download-parties-master', [Request::segment(3)])}}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Download Party Master File" class="btn btn-info m-2">
                                    Party Master File
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                &nbsp;
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Upload CSV File</label>
                            <div class="col-sm-12 col-md-7">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="file">Select File</span>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="file" id="file" aria-describedby="file" accept=".csv" />
                                        <label class="custom-file-label" for="file">Choose file</label>

                                    </div>
                                </div>
                                @error('file')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-7">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php
    $errors_report = [];
    $error = 0;
    $file_info = '';
    $colmns = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'];
    if (Session::get('file')) {
        $file_info = Session::get('file');
        //echo "<pre>"; print_r($file_info); exit();
    }
    if (Session::get('sheet_data')) {
        $rows = Session::get('sheet_data');
    ?>
        <div class="row">
            <div class="col-12">
                <div class="card border-success">
                    <div class="card-header border-bottom">
                        <div class="row">
                            <div class="col-md-12">
                                <h4>
                                    Excel File Data
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <?php for ($i = 0; $i <= 11; $i++) { ?>
                                            <th style="border: 1px solid #d9d7d7;text-align: center;min-width: 100px;background: #f1f1f1;"><?= $colmns[$i] ?></th>
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        <?php for ($i = 0; $i <= 11; $i++) { ?>
                                            <th><?= $rows[0][$i] ?></th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    for ($x = 1; $x < COUNT($rows); $x++) {
                                    ?>
                                        <tr>
                                            <?php
                                            $container_no = '';
                                            for ($i = 0; $i < 12; $i++) {
                                                $cell_address = $colmns[$i] . $x;
                                                $actial_cell_address = $colmns[$i] . $x + 1;
                                                $class = '';
                                                $msg = '';
                                                
                                                if($i==2){
                                                    $container_no = $rows[$x][$i];
                                                }
                                                $flag = check_performance_sheet_data_error($cell_address, $rows[$x][$i]);
                                                if ($flag['error'] > 0) {
                                                    $error++;
                                                    /*
                                                    $errors_report[$x]['address']=$actial_cell_address;
                                                    $errors_report[$x]['error']=$flag['message'];
                                                    */

                                                    $errors_report[]=[
                                                        'address'=>$actial_cell_address, 
                                                        'error'=>$flag['message'],
                                                        'container_no'=>$container_no
                                                    ];
                                            ?>
                                                    <td class="border <?= $flag['class'] ?>" data-toggle="tooltip" data-placement="left" title="" data-original-title="<?= $actial_cell_address . ' : ' . $flag['message'] ?>">
                                                        <?= $rows[$x][$i]; ?>
                                                    </td>
                                                <?php

                                                } else {
                                                ?>
                                                    <td class="border" data-toggle="tooltip" data-placement="left" title="" data-original-title="<?= $actial_cell_address . ' : ' ?>">
                                                        <?= $rows[$x][$i]; ?>
                                                    </td>
                                            <?php
                                                }
                                            } ?>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php if ($error < 1) { ?>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="alert alert-success">
                                        Congratulation! there is no error in your sheet.
                                    </div>
                                </div>
                                <div class="col-md-3 text-right">
                                    <form method="post" action="{{route('store-job-performance', [Request::segment(3)])}}">
                                        @csrf
                                        <input type="hidden" name="file_original_name" value="<?= $file_info['file_original_name'] ?>" />
                                        <input type="hidden" name="file_original_ext" value="<?= $file_info['file_original_ext'] ?>" />
                                        <input type="hidden" name="file_temp_name" value="<?= $file_info['file_temp_name'] ?>" />
                                        <input type="hidden" name="stored_file" value="<?= $file_info['stored_file'] ?>" />
                                        <button type="submit" name="submit" class="btn btn-lg btn-primary">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php } ?>



    <?php
//echo "<pre>"; print_r($errors_report); <?php if (COUNT($errors_report)) {
    if (Session::get('sheet_data') && COUNT($errors_report)) {
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
                                if (COUNT($errors_report)) {
                                    foreach ($errors_report as $error) {
                                ?>
                                        <tr>
                                            <td><?= $error['address'] ?></td>
                                            <td><?= $error['container_no'] ?></td>
                                            <td><?= $error['error'] ?></td>
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



    <?php /*  
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.6/css/dataTables.dataTables.css" />

    <script src="https://cdn.datatables.net/2.0.6/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script>
*/?>



    @section('exfooter')

    <script>
        function deleteContainerBreakup(url) {
            $("#container_breakup_item_delete_form").attr('action', url);
            $('#delete_confirmation_container_breakup').modal('show');
        }
        /*
        function deleteContainerBreakupItem(url) {
            $("#container_breakup_item_delete_form").attr('action', url);
            $('#delete_confirmation_container_breakup_item').modal('show');
        }
        
        $(".data-table").dataTable({
            dom: "Bfrltip",
            serverSide: false,
            paging: false,
            pageLength: 10,
            layout: {
                topStart: {
                    buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                }
            },

        });
        */
    </script>
  @stop


</x-layout-admin>