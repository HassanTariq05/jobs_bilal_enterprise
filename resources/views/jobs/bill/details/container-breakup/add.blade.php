<x-layout-admin>

    <?php
    $tax_id = $head = $cic = 0;
    if (isset($_REQUEST['tax_id'])) {
        $tax_id = $_REQUEST['tax_id'];
    }
    if (isset($_REQUEST['head'])) {
        $head = $_REQUEST['head'];
    }
    if (isset($_REQUEST['cic'])) {
        $cic = $_REQUEST['cic'];
    }
    ?>

    <div class="row d-none">
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
            <div class="accordion" id="accordionBill">
                <div class="card m-0">
                    <div class="card-header bg-primary text-white" role="button" id="billDetails" data-toggle="collapse" data-target="#collapseOneBill" aria-expanded="false" aria-controls="collapseOne">
                        Bill # : <strong>{{$bill->bill_no}}</strong>
                        <?php if (has_permission(33)) { ?>
                            <a href="{{route('edit-job-bill', [$job->id, $bill->id])}}" class="btn shadow-none btn-dark float-right">edit bill info</a>
                        <?php } ?>
                    </div>
                    <div id="collapseOneBill" class="collapse" aria-labelledby="billDetails" data-parent="#accordionBill">
                        <div class="card-body p-2">
                            <table class="table table-sm table-striped table-hover mb-0">
                                <tr>
                                    <td>Client</td>
                                    <td>
                                        <h6>{{$bill->party_id}}</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Bill Date</td>
                                    <td>
                                        <h6>{{$bill->bill_date}}</h6>
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

        <?php if ($rows->count()) { ?>

            <div class="row">
                <div class="col-12">
                    <form method="post" action="">
                        @csrf
                        <div class="card">
                            <div class="card-body">
                                <input type="hidden" name="job_id" value="{{$job->id}}" />
                                <input type="hidden" name="job_bill_id" value="{{$bill->id}}" />
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="size">Bill no.</label>
                                        <textarea name="filter_bill_no" rows="3" class="form-control"><?php if (isset($_REQUEST['filter_bill_no'])) {
                                                                                                            echo $_REQUEST['filter_bill_no'];
                                                                                                        } ?></textarea>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="size">Container no.</label>
                                        <textarea name="filter_container_no" rows="3" class="form-control"><?php if (isset($_REQUEST['filter_container_no'])) {
                                                                                                                echo $_REQUEST['filter_container_no'];
                                                                                                            } ?></textarea>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="size">Size</label>
                                            <select class="form-control select2" id="filter_size" name="filter_size" style="width:100%">
                                                <option value="">--All--</option>
                                                <option <?php if (isset($_REQUEST['filter_size']) && $_REQUEST['filter_size'] == "20") {
                                                            echo 'selected';
                                                        } ?> value="20">20</option>
                                                <option <?php if (isset($_REQUEST['filter_size']) && $_REQUEST['filter_size'] == "40") {
                                                            echo 'selected';
                                                        } ?> value="40">40</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select class="form-control select2" id="filter_status" name="filter_status" style="width:100%">
                                                <option value="">--All--</option>
                                                <option <?php if (isset($_REQUEST['filter_status']) && $_REQUEST['filter_status'] == "full") {
                                                            echo 'selected';
                                                        } ?> value="full">Full</option>
                                                <option <?php if (isset($_REQUEST['filter_status']) && $_REQUEST['filter_status'] == "empty") {
                                                            echo 'selected';
                                                        } ?> value="empty">Empty</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="trucking_mode">Trucking Mode</label>
                                            <select class="form-control select2" id="filter_trucking_mode" name="filter_trucking_mode" style="width:100%">
                                                <option value="">--All--</option>
                                                <option <?php if (isset($_REQUEST['filter_trucking_mode']) && $_REQUEST['filter_trucking_mode'] == "private") {
                                                            echo 'selected';
                                                        } ?> value="private">Private</option>
                                                <option <?php if (isset($_REQUEST['filter_trucking_mode']) && $_REQUEST['filter_trucking_mode'] == "owned") {
                                                            echo 'selected';
                                                        } ?> value="owned">Owned</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mt-4">
                                            <div class="row">
                                                <div class="col-6">
                                                    <a href="<?= route('create-job-bill-detail-container-breakup', [$job->id, $bill->id]) ?>?<?= "tax_id=$tax_id&head=$head&cic=$cic" ?>" class="btn btn-danger btn-block py-2">Refresh</a>
                                                </div>
                                                <div class="col-6">
                                                    <button name="search_container" class="btn btn-primary btn-block py-2">Search</button>
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
            <div class="row">
                <div class="col-12">
                    <form id="apply_rates_form" method="post" action="{{route('store-job-bill-detail-container-breakup', [$job->id, $bill->id])}}">
                        @csrf
                        <div class="card">
                            <div class="card-body">
                                <input type="hidden" name="job_bill_id" id="job_bill_id" value="<?= $bill->id ?>" />
                                <input type="hidden" name="sales_tax_territory_id" id="sales_tax_territory_id" value="<?= $tax_id ?>" />
                                <input type="hidden" name="account_title_id" id="account_title_id" value="<?= $head ?>" />
                                <input type="hidden" name="container_item_code" id="container_item_code" value="<?= $cic ?>" />
                                <input type="hidden" name="ids" id="ids" value="0" />

                                <input type="hidden" name="bl_nos" id="bl_nos" value="0" />
                                <input type="hidden" name="container_ids" id="container_ids" value="0" />
                                <input type="hidden" name="container_data" id="container_data" value="" />

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="rate">Rate</label>
                                            <input id="rate" onchange="make_calculations();" onkeyup="make_calculations();" type="text" class="form-control" name="rate" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="qty">Qty</label>
                                            <input id="qty" readonly type="number" class="form-control" name="qty" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="amount">Amount Excluding Tax</label>
                                            <input id="amount" readonly type="text" class="form-control" name="amount" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="tax">Tax</label>
                                        <div class="input-group mb-2">
                                            <input id="tax_percentage" type="text" onkeyup="calculate_tax_amount();sumup();" class="form-control auto_select" name="tax_percentage" value="0" placeholder="tax percentage" data-toggle="tooltip" data-placement="top" title="" data-original-title="Enter Tax in Percent" />
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">%</div>
                                            </div>
                                            <input id="tax" type="text" onkeyup="calculate_tax_percentage();sumup();" class="form-control auto_select" name="tax" value="0" placeholder="tax amount" data-toggle="tooltip" data-placement="top" title="" data-original-title="Enter Tax in Amount" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="net">Bill Amount</label>
                                            <input id="net" readonly type="text" class="form-control" name="net" value="0" />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <input id="description" type="text" class="form-control" name="description">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mt-4_ text-right">
                                            <button onclick="apply_rates();" name="apply_rate" value="apply_rate" type="button" class="btn btn-primary btn-block_ py-2">Apply Rates</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>All Excel Data : <span id="excel_data_counter"></span></h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th style="min-width:50px;text-align:center;">
                                                        <input id="select_all" onclick="select_all();" type="checkbox" />
                                                    </th>
                                                    <th style="min-width:100px;">Bill of Ladding no.</th>
                                                    <th style="min-width:100px;">Container no.</th>
                                                    <th style="min-width:100px;">Open Cargo</th>
                                                    <th style="min-width:50px;">Size</th>
                                                    <th style="min-width:80px;">Status</th>
                                                    <th style="min-width:100px;">Vehicle no.</th>
                                                    <th style="min-width:120px;">Trucking mode</th>
                                                    <th style="min-width:100px;">Date</th>
                                                    <th style="min-width:100px;">Loading Port</th>
                                                    <th style="min-width:100px;">Off Load</th>
                                                    <th style="min-width:100px;">Name</th>
                                                    <th style="min-width:200px;">Remarks</th>
                                                    <th style="min-width:100px;">Rate</th>
                                                    <th style="min-width:100px;">Tax</th>
                                                    <th style="min-width:100px;">Total</th>
                                                    <th style="min-width:100px;">Head</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if($rows)
                                                <?php $excel_data_counter = 0; ?>
                                                @foreach ($rows as $r)
                                                <?php
                                                $ite = $head . '_' . $r->container_no . '_' . $r->status;
                                                if (!in_array($ite, $xitems_array)) {
                                                ?>
                                                    <tr>
                                                        <td style="text-align:center;">
                                                            <?php if (!$r->account_title_id) { ?>
                                                                <input onclick="getQtyTotal();" type="checkbox" class="container_ids" value="{{$r->container_no}}" data-bl_no="{{ $r->bl_no }}" data-container_no="{{ $r->container_no }}" data-size="{{ $r->size }}" data-status="{{ $r->status }}" data-vehicle_no="{{ $r->vehicle_no }}" data-trucking_mode="{{ $r->trucking_mode }}" data-date="{{ $r->date }}" data-loading_port="{{ $r->loading_port }}" data-off_loading_port="{{ $r->off_loading_port }}" data-party="{{ $r->party }}" data-remarks="{{ $r->remarks }}" />
                                                            <?php } ?>
                                                        </td>
                                                        <td>{{ $r->bl_no }}</td>
                                                        <td>{{ $r->container_no }}</td>
                                                        <td>{{ $r->container_no ? "YES" : "NO" }}</td>
                                                        <td>{{ $r->size }}</td>
                                                        <td>{{ $r->status }}</td>
                                                        <td>{{ $r->vehicle_no }}</td>
                                                        <td>{{ $r->trucking_mode }}</td>
                                                        <td>{{ $r->date }}</td>
                                                        <td>{{ $r->loading_port }}</td>
                                                        <td>{{ $r->off_loading_port }}</td>
                                                        <td>{{ $r->party }}</td>
                                                        <td>{{ $r->remarks }}</td>
                                                        <td>{{ $r->rate }}</td>
                                                        <td>{{ $r->tax }}</td>
                                                        <td>{{ ($r->rate+$r->tax) }}</td>
                                                        <td>
                                                            @if($r->account_title_id)
                                                            {{ $r->account_title->title }}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                <?php $excel_data_counter++;
                                                } ?>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php } else { ?>
            <div class="card">
                <div class="card-header border-bottom bg-danger">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="text-white">Sorry!</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="alert text-danger">
                                Sorry! no performance sheet is uploaded yet. Please <a class="text-dark" href="{{route('create-job-performance', [$job->id])}}">upload Performance sheet now</a>.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>


        <?php
        if ($heads_rates->count()) {

            $bill_item_qty = 0;
            $bill_item_rate = 0;
            $bill_item_amount = 0;
            $bill_item_tax_percentage = 0;
            $bill_item_tax = 0;
            $bill_item_net = 0;
            $bill_item_des = [];
            $counter = 0;

        ?>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Rate Applied</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th style="min-width:100px;">Head</th>
                                                    <th style="min-width:100px;">Description</th>
                                                    <th style="min-width:50px;text-align:right;">Rate</th>
                                                    <th style="min-width:50px;text-align:center;">Qty</th>
                                                    <th style="min-width:80px;text-align:right;">Amount Excluded Tax</th>
                                                    <th style="min-width:100px;text-align:right;">Tax</th>
                                                    <th style="min-width:120px;text-align:right;">Bill Amount</th>
                                                    <th style="min-width:120px;text-align:center;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if($heads_rates)
                                                @foreach ($heads_rates as $row)
                                                <tr>
                                                    <td>{{ $row->account_title->title }}</td>
                                                    <td>
                                                        {{ $row->description }}
                                                        <?php $bill_item_des[] = $row->description;  ?>
                                                    </td>
                                                    <td class="text-right">
                                                        {{ $row->rate }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ $row->qty }}
                                                        <?php $bill_item_qty += $row->qty ?>
                                                    </td>
                                                    <td class="text-right">
                                                        {{ $row->amount }}
                                                        <?php $bill_item_amount += $row->amount ?>
                                                    </td>
                                                    <td class="text-right">
                                                        {{ $row->tax }}
                                                        <?php
                                                        $bill_item_tax += $row->tax;
                                                        $bill_item_tax_percentage += $row->tax_percentage;
                                                        ?>
                                                    </td>
                                                    <td class="text-right">
                                                        {{ $row->net }}
                                                        <?php $bill_item_net += $row->net ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php /*
                                                        <a href="#" data-toggle="tooltip" data-placement="left" title="" data-original-title="Edit Record" class="btn btn-icon  btn-sm btn-primary">
                                                            <i class="far fa-edit"></i>
                                                        </a>
                                                        */ ?>

                                                        <span onclick="hideIt('.breakup_details'); showIt('#details_<?= $row->id ?>');" data-toggle="tooltip" data-placement="left" title="" data-original-title="Show Details" class="btn btn-icon  btn-sm btn-primary">
                                                            <i class="far fa-eye"></i>
                                                        </span>

                                                        <span onclick="deleteContainerBreakup('<?= route('destroy-job-bill-detail-container-breakup', [$row->id]) ?>');" class="btn btn-icon btn-sm btn-danger" data-toggle="tooltip" data-placement="left" title="" data-original-title="Delete Record">
                                                            <i class="fas fa-trash"></i>
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr id="details_<?= $row->id ?>" class="border m-3 hide breakup_details">
                                                    <td colspan="8">
                                                        <div class="text-right p-2">
                                                            <span onclick="hideIt('.breakup_details');" class="btn btn-icon btn-sm btn-light" data-toggle="tooltip" data-placement="left" title="" data-original-title="Hide Details">
                                                                <i class="fa fa-times"></i>
                                                            </span>

                                                            <?php if ($row->items->count()) { ?>
                                                                <div class="table-responsive">
                                                                    <table class="table table-sm bg-light">
                                                                        <thead>
                                                                            <tr class=" text-center">
                                                                                <th>BL #</th>
                                                                                <th>Container #</th>
                                                                                <th>Size</th>
                                                                                <th>Status</th>
                                                                                <th>Vehicle #</th>
                                                                                <th>Trucking Mode</th>
                                                                                <th>Date</th>
                                                                                <th>Loading Port</th>
                                                                                <th>Off Loading Port</th>
                                                                                <th>Party</th>
                                                                                <th>Remarks</th>
                                                                                <th>Rate</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php foreach ($row->items as $item) { ?>
                                                                                <tr class="text-center">
                                                                                    <td><?= $item->bl_no ?></td>
                                                                                    <td><?= $item->container_no ?></td>
                                                                                    <td><?= $item->size ?></td>
                                                                                    <td><?= $item->status ?></td>
                                                                                    <td><?= $item->vehicle_no ?></td>
                                                                                    <td><?= $item->trucking_mode ?></td>
                                                                                    <td><?= $item->date ?></td>
                                                                                    <td><?= $item->loading_port ?></td>
                                                                                    <td><?= $item->off_loading_port ?></td>
                                                                                    <td><?= $item->party ?></td>
                                                                                    <td><?= $item->remarks ?></td>
                                                                                    <td><?= $item->rate ?></td>
                                                                                </tr>
                                                                            <?php } ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            <?php } else { ?>
                                                                <div class="alert alert-danger">
                                                                    Sorry! no items available.
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php $counter++; ?>
                                                @endforeach
                                                @endif
                                            </tbody>
                                            <tfoot>
                                                <tr class="border-top">
                                                    <th colspan="2" class="text-center">TOTAL</th>
                                                    <th class="text-right">
                                                        <?php $bill_item_rate = number_format((float)($bill_item_amount / $bill_item_qty), 2, '.', ''); ?>
                                                        {{($bill_item_rate)}}
                                                    </th>

                                                    <th class="text-center">{{$bill_item_qty}}</th>
                                                    <th class="text-right">{{$bill_item_amount}}</th>
                                                    <th class="text-right">{{$bill_item_tax}}</th>
                                                    <th class="text-right">{{$bill_item_net}}</th>

                                                    <th></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if ($heads_rates) { ?>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        <form method="POST" action="{{route('store-container-breakup-bill-item', [$job->id, $bill->id])}}">
                                            @csrf
                                            <input type="hidden" name="job_id" value="<?= $job->id ?>" />
                                            <input type="hidden" name="job_bill_id" value="<?= $bill->id ?>" />
                                            <input type="hidden" name="account_title_id" value="<?= $head ?>" />
                                            <input type="hidden" name="sales_tax_territory_id" value="<?= $tax_id ?>" />
                                            <input type="hidden" name="container_item_code" value="<?= $cic ?>" />
                                            <input type="hidden" name="qty" value="<?= $bill_item_qty ?>" />
                                            <input type="hidden" name="rate" value="<?= ($bill_item_rate) ?>" />
                                            <input type="hidden" name="amount" value="<?= $bill_item_amount ?>" />

                                            <input type="hidden" name="tax" value="<?= $bill_item_tax ?>" />
                                            <input type="hidden" name="tax_percentage" value="<?= number_format((float)($bill_item_tax_percentage / $counter), 2, '.', '') ?>" />
                                            <input type="hidden" name="net" value="<?= $bill_item_net ?>" />
                                            <input type="hidden" name="description" value="<?= implode(', ', $bill_item_des); ?>" />

                                            <button class="btn btn-primary" type="submit">
                                                Add Items to bill
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php }  ?>
                    </div>
                </div>
            </div>

        <?php } ?>


    <?php } else { ?>

        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger">
                    Sorry! no one is allow to add/edit bill items.
                </div>
            </div>
        </div>

    <?php } ?>



    @section('exfooter')


    <div id="delete_confirmation_container_breakup" class="modal fade" tabindex="-1" role="dialog" id="list">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="container_breakup_item_delete_form" method="get" action="">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete Confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-2">Are you sure you want to delete this?</p>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger" type="submit">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        
        $(document).ready(function() {
            $("#excel_data_counter").html($("#excel_data_counter_value").val());
        });

        function deleteContainerBreakup(url) {
            $("#container_breakup_item_delete_form").attr('action', url);
            $('#delete_confirmation_container_breakup').modal('show');
        }

        function select_all() {
            if ($('#select_all').is(":checked")) {
                $(".container_ids").attr('checked', true);
            } else {
                $(".container_ids").attr('checked', false);
            }
            getQtyTotal();
        }

        function getQtyTotal() {
            var counter = 0;
            $(".container_ids:checkbox:checked").each(function() {
                counter++;
            });

            $("#qty").val(counter);
            make_calculations();
        }

        function apply_rates() {
            var container_ids = $("#container_ids").val();
            if ($("#qty").val() < 1) {
                alert("Please select containers to apply the rates.");
                return false;
            } else if ($("#net").val() < 1) {
                alert("Please apply the tax.");
                return false;
            } else {
                container_ids = 0;
                var container_data = [];

                $(".container_ids:checkbox:checked").each(function() {
                    container_ids += ',' + this.value;
                    var r = {
                        'bl_no': $(this).data('bl_no'),
                        'container_no': $(this).data('container_no'),
                        'size': $(this).data('size'),
                        'status': $(this).data('status'),
                        'vehicle_no': $(this).data('vehicle_no'),
                        'trucking_mode': $(this).data('trucking_mode'),
                        'date': $(this).data('date'),
                        'loading_port': $(this).data('loading_port'),
                        'off_loading_port': $(this).data('off_loading_port'),
                        'party': $(this).data('party'),
                        'remarks': $(this).data('remarks')
                    };
                    container_data.push(r);
                });
                $("#container_ids").val(container_ids);
                $("#container_data").val(JSON.stringify(container_data));


                //console.log(container_data);
                //console.log(637);
                //console.log(JSON.stringify(container_data));

                $("#apply_rates_form").submit();
            }
        }

        /*
        function reset_tax_amount() {
            $("#tax_percentage").val('');
            $("#tax").val('');
        }
        



        function tax_calculation(){
            calculate_tax_amount();
            calculate_tax_percentage()
        }


*/
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


        function make_calculations() {
            var qty = parseInt($("#qty").val());
            var rate = parseInt($("#rate").val());
            if (qty && rate) {
                var qty_rate_total = qty * rate;
                $("#amount").val(qty_rate_total);
            } else {
                $("#amount").val('')
            }
        }
    </script>


    @stop

</x-layout-admin>