<x-layout-admin>

<?php 
syncInvoiceItemByCode(737123206);
?>


    <div class="row">
        <div class="col-md-6">
            <div class="accordion" id="accordionJob">
                <div class="card m-0">
                    <div class="card-header bg-dark  text-white" role="button" id="jobDetails" data-toggle="collapse" data-target="#collapseOneJob" aria-expanded="false" aria-controls="collapseOne">
                        Job # : <strong>{{$job->job_no}}</strong>
                        <?php if (has_permission(69)) { ?>
                            <a href="{{route('edit-job', [$job->id])}}" class="btn shadow-none btn-primary float-right">edit job info</a>
                        <?php } ?>
                    </div>
                    <div id="collapseOneJob" class="collapse" aria-labelledby="jobDetails" data-parent="#accordionJob">
                        <div class="card-body p-2">
                            <table class="table table-sm table-striped table-hover mb-0">
                                <tr>
                                    <td>Customer</td>
                                    <td>
                                        <h6>{{$job->party->title}}</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Company</td>
                                    <td>
                                        <h6>{{$job->company->title}}</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Location</td>
                                    <td>
                                        <h6>{{$job->location->title}}</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Job Type</td>
                                    <td>
                                        <h6>{{$job->job_type->title}}</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Document Date</td>
                                    <td>
                                        <h6>{{$job->document_date}}</h6>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="accordion" id="accordionInv">
                <div class="card m-0">
                    <div class="card-header bg-primary text-white" role="button" id="invDetails" data-toggle="collapse" data-target="#collapseOneInv" aria-expanded="false" aria-controls="collapseOne">
                        Invoice # : <strong>{{$inv->inv_no}}</strong>
                        <?php if (has_permission(81)) { ?>
                            <a href="{{route('edit-job-invoice', [$job->id, $inv->id])}}" class="btn shadow-none btn-dark float-right">edit invoice info</a>
                        <?php } ?>
                    </div>
                    <div id="collapseOneInv" class="collapse" aria-labelledby="invDetails" data-parent="#accordionInv">
                        <div class="card-body p-2">
                            <table class="table table-sm table-striped table-hover mb-0">
                                <tr>
                                    <td>Client</td>
                                    <td>
                                        <h6>{{$inv->party_id}}</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Invoice Date</td>
                                    <td>
                                        <h6>{{$inv->inv_date}}</h6>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <?php if (!$job->approved) { ?>
        <div class="row">
            <div class="col-12">
                <form method="post" action="{{route('store-job-invoice-detail', [$job->id, $inv->id])}}">
                    @csrf
                    <div class="card">
                        <div class="card-header border-bottom">
                            <h4>Add Invoice Items</h4>
                        </div>
                        <div class="card-body">
                            <input type="hidden" name="container_item_code" id="container_item_code" value="{{rand()}}" />
                            <input type="hidden" name="job_id" value="{{$job->id}}" />
                            <input type="hidden" name="job_invoice_id" value="{{$inv->id}}" />
                            <div class="row">
                                <div class="col-md-6">
                                    <x-combobox of="sales_tax_territories" label="Sales Tax Territory" ref="sales_tax_territory_id" inline=0 />
                                </div>
                                <div class="col-md-6">
                                    <x-combobox of="account_titles" label="Head" ref="account_title_id" inline=0 />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="rate">Rate</label>
                                        <input id="rate" onkeyup="calculate_amount_by_rate_qty(); sumup();" type="text" class="form-control float" name="rate" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="qty">Qty</label>
                                        <input id="qty" onkeyup="calculate_amount_by_rate_qty(); sumup();" type="number" class="form-control" name="qty" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="amount">Amount Excluding Tax</label>
                                        <input id="amount" onkeyup="reset_tax_amount();" readonly type="text" class="form-control float" name="amount" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="tax">Tax</label>
                                    <div class="input-group mb-2">
                                        <input id="tax_percentage" type="text" onkeyup="calculate_tax_amount(); sumup();" class="form-control auto_select float" name="tax_percentage" value="0" placeholder="tax percentage" data-toggle="tooltip" data-placement="top" title="" data-original-title="Enter Tax in Percent" />
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">%</div>
                                        </div>
                                        <input id="tax" type="text" onkeyup="calculate_tax_percentage(); sumup();" class="form-control auto_select float" name="tax" value="0" placeholder="tax amount" data-toggle="tooltip" data-placement="top" title="" data-original-title="Enter Tax in Amount" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="net">Invoice Amount</label>
                                        <input id="net" readonly type="text" class="form-control float" name="net" value="0" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <?php /*
                                    <div class="form-group">
                                        <label for="container_breakup">Container Breakup</label>
                                        <select onchange="show_excel_sheet_data_model(this.value);" class="form-control" id="container_breakup">
                                            <?php if ($performance_uploaded_files->count()) { ?>
                                                <option value="">No File Uploaded yet</option>
                                                <?php foreach ($performance_uploaded_files as $file) { ?>
                                                    <option value="<?= $file->id ?>"> Uploaded at : <?= $file->created_at ?></option>
                                                <?php } ?>
                                            <?php } else { ?>
                                                <option value="">No File Uploaded yet</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    */ ?>
                                    <div class="form-group">
                                        <label for="container_breakup">&nbsp;</label>
                                        <button onclick="goto_pick_container();" type="button" class="btn btn-primary btn-block">
                                            Pick Container
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <input id="description" type="text" class="form-control" name="description">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer border-top">
                            <div class="row">
                                <div class="col-12 text-right">
                                    <?php if (has_permission(86)) { ?>
                                        <button class="btn btn-primary">Submit</button>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php } ?>

    <div class="row">
        <div class="col-12">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Head</th>
                        <th>Description</th>
                        <th class="text-right">Amount Excluding Tax</th>
                        <th class="text-right">Sales Tax</th>
                        <th class="text-right">Invoice Amount</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_amount = $total_tax = $total_net = 0;
                    if ($rows) {
                        foreach ($rows as $row) {
                    ?>
                            <tr>
                                <td><?= $row->account_title->title ?></td>
                                <td><?= $row->description ?></td>
                                <td class="text-right">@money($row->amount)</td>
                                <td class="text-right">@money($row->tax)</td>
                                <td class="text-right">@money($row->net)</td>
                                <td class="text-center">
                                    <?php
                                    if (has_permission(87)) {
                                        if ($row->is_manual) {
                                    ?>
                                            <a href="{{route('edit-job-invoice-detail', [$job->id, $inv->id, $row->id])}}" class="btn btn-icon  btn-sm btn-primary" data-placement="left" title="" data-original-title="Manually Entery">
                                                <i class="far fa-edit"></i>
                                            </a>
                                        <?php
                                        } else {
                                        ?>
                                            <a href="{{route('edit-job-invoice-detail-container-breakup', [$job->id, $inv->id, $row->id, $row->container_item_code])}}" class="btn btn-icon  btn-sm btn-primary" data-toggle="tooltip" data-placement="left" title="" data-original-title="Container Breakup Applied">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                    <?php
                                        }
                                    }
                                    ?>
                                    <?php
                                    if (!$job->approved) {
                                        if (has_permission(88)) {
                                    ?>
                                            <a href="{{route('trash-job-invoice-detail', [$row->id])}}" class="btn btn-icon  btn-sm btn-danger"><i class="fas fa-times"></i></a>
                                    <?php
                                        }
                                    }
                                    ?>
                                </td>
                            </tr>
                    <?php
                        }
                    }
                    $totals = $inv->job_invoice_totals();
                    ?>
                </tbody>
                <tfoot>
                    <tr class="bg-dark text-white">
                        <th colspan="2" class="text-right">Total</th>
                        <th class="text-right">@money($totals['amount'])</th>
                        <th class="text-right">@money($totals['tax'])</th>
                        <th class="text-right">@money($totals['net'])</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>


    @section('exfooter')

    <script>
        function goto_pick_container() {
            var sales_tax_territory_id = $("#sales_tax_territory_id").val();
            var account_title_id = $("#account_title_id").val();
            var cic = $("#container_item_code").val();
            if (sales_tax_territory_id == '') {
                alert("Please select Sales Tax Territory");
                return false;
            } else if (account_title_id == '') {
                alert("Please select Head");
                return false;
            } else {
                window.location.replace("<?= route('create-job-invoice-detail-container-breakup', [$job->id, $inv->id]) ?>?tax_id=" + sales_tax_territory_id + "&head=" + account_title_id + "&cic=" + cic);
            }
        }

        function reset_tax_amount() {
            $("#tax_percentage").val('');
            $("#tax").val('');
        }

        function calculate_tax_amount() {
            $("#tax_amount").val('');
            var amount = 0;
            var percent = $("#tax_percentage").val();
            if ($("#amount").val()) {
                amount = $("#amount").val();
            }
            if (percent != '') {
                $("#tax").val(((amount * percent) / 100));
            }
        }

        function calculate_tax_percentage() {
            var amount = 0;
            var tax = $("#tax").val();
            if ($("#amount").val()) {
                amount = $("#amount").val();
            }
            if (tax != '') {
                $("#tax_percentage").val(((tax * 100) / amount).toFixed(2));
            }
        }

        function sumup() {
            var amount = 0;
            var tax = 0;
            if ($("#amount").val()) {
                amount = $("#amount").val();
            }
            if ($("#tax").val()) {
                tax = $("#tax").val();
            }
            var net = parseFloat(amount) + parseFloat(tax);
            $("#net").val(net);
        }

        function show_excel_sheet_data_model(id) {
            if (id) {
                $("#excel_sheet_data_modal").modal('show');
            }
        }
    </script>


    <div class="modal fade" tabindex="-1" role="dialog" id="excel_sheet_data_modal">
        <div class="modal-dialog" style="max-width:90%;" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Uploaded Performance Sheet Data</h5>
                </div>
                <div id="sheet_data" class="modal-body">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>

    @stop

</x-layout-admin>