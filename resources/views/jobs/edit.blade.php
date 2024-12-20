<x-layout-admin>
    <?php $jt = $row->job_totals(); ?>

    <?php if ($row->job_status_id == 3) { ?>

        <div class="row">
            <div class="col-md-12">
                <img class="img-fluid p-5" src="{{asset('assets/img/cancelled.jpg')}}" />
            </div>
        </div>

    <?php } ?>

    <?php if (has_permission(67)) { ?>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1 mb-3">
                    <div class="card-icon bg-info">
                        <i class="far fa-newspaper"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Revenue</h4>
                        </div>
                        <div class="card-body" style="padding-top:0px !important;">
                            @money($jt['receivable'])
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1 mb-3">
                    <div class="card-icon bg-danger">
                        <i class="far fa-newspaper"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Expense</h4>
                        </div>
                        <div class="card-body" style="padding-top:0px !important;">
                            @money($jt['payable'])
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1 mb-3">
                    <div class="card-icon bg-success">
                        <i class="far fa-newspaper"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Net</h4>
                        </div>
                        <div class="card-body" style="padding-top:0px !important;">
                            <?php $net = ($jt['receivable'] - $jt['payable']) ?>
                            @money($net)
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <div id="" class="row">
        <div class="col-12">
            <form method="post" action="{{route('update-job', [$row->id])}}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="approved" name="approved" value="{{$row->approved}}" />
                <div class="card">
                    <div class="card-header border-bottom">


                        <div class="row">
                            <div class="col-md-6">
                                <h4>Edit : &nbsp;&nbsp;&nbsp;
                                    <span class="badge badge-secondary text-white"> Job # {{$row->job_no}} </span>
                                </h4>
                            </div>
                            <div class="col-md-6 text-right">
                                JOB STATUS:
                                <?php if ($row->job_status_id < 2) {
                                    echo '<span class="badge badge-pill badge-info">Open</span>';
                                } else {
                                    echo '<span class="badge badge-pill badge-success">Closed</span>';
                                }
                                ?>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <x-combobox of="parties" selected="{{$row->party_id}}" label="Customer" ref="party_id" inline=0 />
                            </div>
                            <div class="col-md-4">
                                <x-combobox of="companies" selected="{{$row->company_id}}" label="Company" ref="company_id" inline=0 />
                            </div>
                            <div class="col-md-4">
                                <x-combobox of="locations" selected="{{$row->location_id}}" label="Location" ref="location_id" inline=0 />
                            </div>
                            <div class="col-md-4">
                                <x-combobox of="job_types" selected="{{$row->job_type_id}}" label="Job Type" ref="job_type_id" multiple="true" inline=0 />

                                <div class="form-group">
                                    <label for="job_type_id">Job Types</label>
                                    <!-- selectric -->
                                    <select class="form-control select2" multiple id="job_type_id" name="job_type_id" style="width:100%">
                                        <option value="">--select--</option>
                                        @if($job_types)
                                        @foreach($job_types as $t)
                                        <option value="{{$t->id}}">
                                            @if(isset($t->title))
                                            {{$t->title}}
                                            @elseif(isset($t->name))
                                            {{$t->name}}
                                            @endif
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @error('job_type_id')
                                    <div class="text-danger">required</div>
                                    @enderror
                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="document_date">Document Date</label>
                                    <input type="date" id="document_date" name="document_date" value="{{$row->document_date}}" class="form-control" />
                                    @error('document_date')
                                    <div class="text-danger">required</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <x-combobox of="job_statuses" selected="{{$row->job_status_id}}" label="Job Status" ref="job_status_id" inline=0 />
                            </div>
                            <div class="col-md-4">
                                <?php /*
                                <div class="form-group">
                                    <label for="approved">Approve Job</label>
                                    <select class="form-control selectric" id="approved" name="approved">
                                        <option value="1">Mark This Job as Approved</option>
                                        <option value="0">Mark This Job as Unapproved</option>
                                    </select>
                                </div>
                                */ ?>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="remarks">Remarks</label>
                                    <textarea class="form-control" id="remarks" name="remarks">{{$row->remarks}}</textarea>
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
                                    <?php if ($row->files) { ?>
                                        <div class="row">
                                            <?php foreach ($row->files as $f) { ?>
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
                                    <div>{{$row->created_at}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <?php if (Auth::user()->id < 3) { ?>
                                    <?php if ($row->approved) { ?>
                                        <button onclick="updateApprovedValue(0);" class="btn btn-danger">Mark as Unapproved</button>
                                    <?php } else { ?>
                                        <button onclick="updateApprovedValue(1);" class="btn btn-success">Mark as Approved</button>
                                    <?php } ?>
                                <?php } ?>
                                
                                <?php if (has_permission(249)) { ?>
                                <a type="button" href="{{route('job-performance', [$row->id])}}" class="btn btn-dark ml-3">Job Performance</a>
                                <?php } ?>
                                <?php //if (has_permission(249)) { ?>
                                <!-- <a type="button" href="{{route('job-performance-new', [$row->id])}}" class="btn btn-dark ml-3">Job Performance</a> -->
                                <?php //} ?>
                            </div>
                            <div class="col-md-6">

                                <?php
                                if (has_permission(69)) {
                                    if (!$row->approved) {
                                ?>
                                        <div class="text-right">
                                            <button class="btn btn-primary">Update</button>
                                        </div>
                                <?php
                                    }
                                }
                                ?>

                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="job_main_div" class="row">
        <div class="col-12">
            <nav>
                <div class="nav nav-tabs  nav-justified" id="nav-tab" role="tablist">
                    <button class="nav-link active m-1" id="nav-receivable-tab" data-toggle="tab" data-target="#nav-receivable" type="button" role="tab" aria-controls="nav-receivable" aria-selected="true">
                        Receivable
                    </button>
                    <button class="nav-link m-1" id="nav-payable-tab" data-toggle="tab" data-target="#nav-payable" type="button" role="tab" aria-controls="nav-payable" aria-selected="false">
                        Payable
                    </button>
                    <button class="nav-link m-1" id="nav-receipts-tab" data-toggle="tab" data-target="#nav-receipts" type="button" role="tab" aria-controls="nav-receipts" aria-selected="false">
                        Receipts
                    </button>
                    <button class="nav-link m-1" id="nav-payments-tab" data-toggle="tab" data-target="#nav-payments" type="button" role="tab" aria-controls="nav-payments" aria-selected="false">
                        Payments
                    </button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-receivable" role="tabpanel" aria-labelledby="nav-receivable-tab">

                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 text-end">
                                    <?php
                                    if (has_permission(80)) {
                                        if (!$row->approved) {
                                    ?>
                                            <a href="{{route('create-job-invoice', [$row->id])}}" role="btn" class="btn btn-sm btn-primary pull-left">
                                                Add New Invoice
                                            </a>
                                    <?php
                                        }
                                    }
                                    ?>
                                </div>
                                <div class="col-md-12">
                                    <table class="table table-sm table-condensed">
                                        <thead>
                                            <tr>
                                                <th>Invoice Date.</th>
                                                <th>Invoice no.</th>
                                                <th>Party</th>
                                                <th class="text-right">Amount</th>
                                                <th class="text-right">Received</th>
                                                <th class="text-right">Balance</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $invoice_grand_total = $invoice_total_received = $invoice_total_balance = 0;
                                            if ($row->job_invoices) {
                                                foreach ($row->job_invoices as $inv)
                                                {

                                                    $totals = $inv->job_invoice_totals();
                                                    $invoice_grand_total += $totals['net'];

                                                    $received = $inv->job_invoice_total_received();
                                                    $invoice_total_received += $received;

                                                    $balance = $inv->job_invoice_balance();
                                                    $invoice_total_balance += $balance;
                                                    
                                            ?>
                                                    <tr>
                                                        <td><?= $inv->inv_date ?></td>
                                                        <td><?= $inv->inv_no ?></td>
                                                        <td><?= $inv->party->title ?></td>
                                                        <td class="text-right">@money($totals['net'])</td>
                                                        <td class="text-right">@money($received)</td>
                                                        <td class="text-right">@money($balance)</td>
                                                        <td class="text-center">

                                                            <?php if (!$row->approved) { ?>

                                                                <div class="btn-group dropleft">
                                                                    <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        actions
                                                                    </button>
                                                                    <div class="dropdown-menu dropleft shadow border-light">

                                                                        <?php if (has_permission(97)) { ?>
                                                                            <span class="dropdown-item cursor-pointer" onclick="getReceipts(<?= $inv->id ?>);" title="Add Receipt">
                                                                                <i class="far fa-file mr-2"></i>
                                                                                View Receipts
                                                                            </span>
                                                                        <?php } ?>

                                                                        <?php if (has_permission(98)) { ?>
                                                                            <a href="{{route('create-job-receipt')}}?inv=<?= $inv->id ?>" class="dropdown-item" title="Add Receipt">
                                                                                <i class="far fa-file mr-2"></i>
                                                                                Add Receipt
                                                                            </a>
                                                                        <?php } ?>

                                                                        <?php if (has_permission(81)) { ?>
                                                                            <a href="{{route('edit-job-invoice', [$row->id, $inv->id])}}" class="dropdown-item" title="Edit Invoice Information">
                                                                                <i class="far fa-edit mr-2"></i>
                                                                                Edit Invoice
                                                                            </a>
                                                                        <?php } ?>

                                                                        <?php if (has_permission(92)) { ?>
                                                                            <a href="{{route('edit-job-invoice', [$row->id, $inv->id])}}" class="dropdown-item" title="Edit Invoice Information">
                                                                                <i class="fa fa-upload mr-2"></i>
                                                                                Upload File
                                                                            </a>
                                                                        <?php } ?>

                                                                        <?php if (has_permission(86)) { ?>
                                                                            <a href="{{route('create-job-invoice-detail', [$row->id, $inv->id])}}" class="dropdown-item" title="Edit Invoice List Items">
                                                                                <i class="fa fa-list mr-2"></i>
                                                                                Add Invoice List Items
                                                                            </a>
                                                                        <?php } ?>

                                                                            <a href="{{route('invoice-generate-pdf', [$inv->id])}}" class="dropdown-item" title="Edit Invoice List Items">
                                                                                <i class="far fa-file-pdf mr-2"></i>
                                                                                Generate Invoice PDF
                                                                            </a>

                                                                        <?php if (has_permission(82)) { ?>
                                                                            <a href="{{route('trash-job-invoice', [$inv->id])}}" class="dropdown-item">
                                                                                <i class="fas fa-times mr-2"></i>
                                                                                Delete Invoice
                                                                            </a>
                                                                        <?php } ?>

                                                                    </div>
                                                                </div>

                                                            <?php } else { ?>

                                                                <?php if (has_permission(86)) { ?>
                                                                    <a href="{{route('create-job-invoice-detail', [$row->id, $inv->id])}}" class="btn btn-icon  btn-sm btn-dark" title="Edit Invoice List Items"><i class="fa fa-list"></i></a>
                                                                <?php } ?>

                                                            <?php } ?>

                                                        </td>

                                                    </tr>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr class="bg-dark text-white">
                                                <th colspan="3" class="text-right">Total</th>
                                                <th class="text-right">@money($invoice_grand_total)</th>
                                                <th class="text-right">@money($invoice_total_received)</th>
                                                <th class="text-right">@money($invoice_total_balance)</th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="tab-pane fade" id="nav-payable" role="tabpanel" aria-labelledby="nav-payable-tab">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <?php
                                if (has_permission(32)) {
                                    if (!$row->approved) {
                                ?>
                                        <div class="col-md-12 text-end">
                                            <a href="{{route('create-job-bill', [$row->id])}}" class="btn btn-sm btn-primary pull-left">
                                                Add New Bill
                                            </a>
                                        </div>
                                <?php
                                    }
                                }
                                ?>
                                <div class="col-md-12">
                                    <table class="table table-sm table-condensed">
                                        <thead>
                                            <tr>
                                                <th>Bill Date.</th>
                                                <th>Bill no.</th>
                                                <th>Party</th>
                                                <th class="text-right">Amount</th>
                                                <th class="text-right">Paid</th>
                                                <th class="text-right">Balance</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $bill_grand_total = $bill_total_paid = $bill_total_balance = 0;
                                            if ($row->job_bills) {
                                                foreach ($row->job_bills as $bill) {

                                                    $totals = $bill->job_bill_totals();
                                                    $bill_grand_total += $totals['net'];

                                                    $paid = $bill->job_bill_total_paid();
                                                    $bill_total_paid += $paid;

                                                    $balance = $bill->job_bill_balance();
                                                    $bill_total_balance += $balance;
                                            ?>
                                                    <tr>
                                                        <td><?= $bill->bill_date ?></td>
                                                        <td><?= $bill->bill_no ?></td>
                                                        <td><?= $bill->party->title ?></td>
                                                        <td class="text-right">@money($totals['net'])</td>
                                                        <td class="text-right">@money($paid)</td>
                                                        <td class="text-right">@money($balance)</td>
                                                        <td class="text-center">
                                                            <?php if (!$row->approved) { ?>

                                                                <div class="btn-group dropleft">
                                                                    <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        actions
                                                                    </button>
                                                                    <div class="dropdown-menu dropleft">
                                                                        <?php if (has_permission(49)) { ?>
                                                                            <a href="#" class="dropdown-item" onclick="getPayments(<?= $bill->id ?>);">
                                                                                <i class="far fa-file mr-2"></i>
                                                                                View Payments
                                                                            </a>
                                                                        <?php } ?>

                                                                        <?php if (has_permission(50)) { ?>
                                                                            <a href="{{route('create-job-payment')}}?bill=<?= $bill->id ?>" class="dropdown-item">
                                                                                <i class="far fa-file mr-2"></i>
                                                                                Add Payment
                                                                            </a>
                                                                        <?php } ?>

                                                                        <?php if (has_permission(33)) { ?>
                                                                            <a href="{{route('edit-job-bill', [$row->id, $bill->id])}}" class="dropdown-item">
                                                                                <i class="far fa-edit mr-2"></i>
                                                                                Edit Bill
                                                                            </a>
                                                                        <?php } ?>

                                                                        <?php if (has_permission(44)) { ?>
                                                                            <a href="{{route('edit-job-bill', [$row->id, $bill->id])}}" class="dropdown-item">
                                                                                <i class="far fa-upload mr-2"></i>
                                                                                Upload File
                                                                            </a>
                                                                        <?php } ?>

                                                                        <?php if (has_permission(38)) { ?>
                                                                            <a href="{{route('create-job-bill-detail', [$row->id, $bill->id])}}" class="dropdown-item">
                                                                                <i class="fa fa-list mr-2"></i>
                                                                                Add Bill List Items
                                                                            </a>
                                                                        <?php } ?>

                                                                        <?php if (has_permission(34)) { ?>
                                                                            <a href="{{route('trash-job-bill', [$bill->id])}}" class="dropdown-item">
                                                                                <i class="fas fa-times mr-2"></i>
                                                                                Delete Bill
                                                                            </a>
                                                                        <?php } ?>

                                                                    </div>
                                                                </div>
                                                            <?php } else { ?>
                                                                <?php if (has_permission(32)) { ?>
                                                                    <a href="{{route('create-job-bill', [$row->id, $bill->id])}}" class="btn btn-icon  btn-sm btn-dark" title="Edit Bill List Items"><i class="fa fa-list"></i></a>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr class="bg-dark text-white">
                                                <th colspan="3" class="text-right">Total</th>
                                                <th class="text-right">@money($bill_grand_total)</th>
                                                <th class="text-right">@money($bill_total_paid)</th>
                                                <th class="text-right">@money($bill_total_balance)</th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-receipts" role="tabpanel" aria-labelledby="nav-receipts-tab">
                    <div>

                        <div id="accordion">

                            <?php
                            $receipts = $row->job_receipts();

                            if (COUNT($receipts)) {
                                $c = 1;
                                foreach ($receipts as $receipt) {
                            ?>
                                    <div class="accordion bg-light">
                                        <div class="accordion-header collapsed" role="button" data-toggle="collapse" data-target="#panel-body-<?= $c ?>" aria-expanded="true">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    Document Date : <?= $receipt->document_date ?>
                                                </div>
                                                <div class="col-md-4">
                                                    Receipt # : <?= $receipt->receipt_no ?>
                                                </div>
                                                <div class="col-md-4">
                                                    Payment Mode : <?php
                                                                    if ($receipt->payment_mode_id) {
                                                                        echo $receipt->payment_mode->title;
                                                                    }
                                                                    ?>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="accordion-body collapse" id="panel-body-<?= $c ?>" data-parent="#accordion">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="font-weight-bold">Sales Tax Territory</div>
                                                    <div>
                                                        <?php if ($receipt->sales_tax_territory_id) echo  $receipt->sales_tax_territory->title; ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="font-weight-bold">Bank</div>
                                                    <div>
                                                        <?php if ($receipt->bank_id) echo  $receipt->bank->title; ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="font-weight-bold">Account Title</div>
                                                    <div>
                                                        <?php if ($receipt->bank_account_id) echo  $receipt->bank_account->title; ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="font-weight-bold">Instrument Amount</div>
                                                    <div><?= amount($receipt->instrument_amount) ?></div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="font-weight-bold">Instrument #</div>
                                                    <div><?= $receipt->instrument_number ?></div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="font-weight-bold">Instrument Date</div>
                                                    <div><?= $receipt->instrument_date ?></div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="font-weight-bold">Received From</div>
                                                    <div><?= $receipt->received_from ?></div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <table class="table table-sm bg-white text-dark mt-3 shadow">
                                                        <thead>
                                                            <tr>
                                                                <th colspan="8">
                                                                    Invoices Details
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <th class="text-center">#</th>
                                                                <th class="text-center">Invoice #</th>
                                                                <th class="text-center">Head</th>
                                                                <th class="text-center">Sales Tax With Held</th>
                                                                <th class="text-center">Income Tax With Held</th>
                                                                <th class="text-center">Adjustment Amount</th>
                                                                <th class="text-right">Received Amount</th>
                                                                <th class="text-right">Total</th>
                                                            </tr>
                                                        </thead>
                                                        <?php
                                                        $stwh = $itwh = $aa = $ra = $t = 0;
                                                        if ($receipt->items->count()) {
                                                            $c = 1;
                                                            foreach ($receipt->items as $i) {
                                                                $stwh += $i->sales_tax_with_held;
                                                                $itwh += $i->income_tax_with_held;
                                                                $aa += $i->adjustment_amount;
                                                                $ra += $i->received_amount;
                                                                $t += $i->total;
                                                        ?>
                                                                <tr>
                                                                    <td class="text-center"><?= $c ?></td>
                                                                    <td class="text-center"><?= $i->job_invoice->inv_no ?></td>
                                                                    <td class="text-center"><?php if ($i->account_title_id) echo $i->account_title->title; ?></td>
                                                                    <td class="text-right"><?= amount($i->sales_tax_with_held) ?></td>
                                                                    <td class="text-right"><?= amount($i->income_tax_with_held) ?></td>
                                                                    <td class="text-right"><?= amount($i->adjustment_amount) ?></td>
                                                                    <td class="text-right"><?= amount($i->received_amount) ?></td>
                                                                    <td class="text-right"><?= amount($i->total) ?></td>
                                                                </tr>
                                                            <?php $c++;
                                                            } ?>
                                                            <tr class="bg-light shadow">
                                                                <th colspan="3" class="text-right">Total</th>
                                                                <th class="text-right"><?= amount($stwh) ?></th>
                                                                <th class="text-right"><?= amount($itwh) ?></th>
                                                                <th class="text-right"><?= amount($aa) ?></th>
                                                                <th class="text-right"><?= amount($ra) ?></th>
                                                                <th class="text-right"><?= amount($t) ?></th>
                                                            </tr>
                                                        <?php
                                                        }  ?>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                <?php $c++;
                                }
                            } else {
                                ?>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="alert alert-danger">Sorry! records not found.</div>
                                    </div>
                                </div>

                            <?php
                            }
                            ?>
                        </div>
                    </div>


                </div>
                <div class="tab-pane fade" id="nav-payments" role="tabpanel" aria-labelledby="nav-payments-tab">
                    <?php

                    $payments = $row->job_payments();
                    if (COUNT($payments) > 0) {
                        $c = 1;
                        foreach ($payments as $row) {
                    ?>
                            <div class="accordion bg-light">
                                <div class="accordion-header collapsed" role="button" data-toggle="collapse" data-target="#panel-body-<?= $c ?>" aria-expanded="true">
                                    <div class="row">
                                        <div class="col-md-4">
                                            Document Date : <?= $row->document_date ?>
                                        </div>
                                        <div class="col-md-4">
                                            Payment # : <?= $row->payment_no ?>
                                        </div>
                                        <div class="col-md-4">
                                            Payment Mode : <?php if ($row->payment_mode_id) echo $row->payment_mode->title ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-body collapse" id="panel-body-<?= $c ?>" data-parent="#accordion">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="font-weight-bold">Sales Tax Territory</div>
                                            <div>
                                                <?php if($row->sales_tax_territory_id) echo $row->sales_tax_territory->title ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="font-weight-bold">Bank</div>
                                            <div>
                                                <?php if($row->bank_id) echo $row->bank->title ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="font-weight-bold">Account Title</div>
                                            <div>
                                            <?php if($row->bank_account_id) echo $row->bank_account->title ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="font-weight-bold">Instrument Amount</div>
                                            <div><?= amount($row->instrument_amount) ?></div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="font-weight-bold">Instrument #</div>
                                            <div><?= $row->instrument_number ?></div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="font-weight-bold">Instrument Date</div>
                                            <div><?= $row->instrument_date ?></div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="font-weight-bold">Paid To</div>
                                            <div><?= $row->paid_to ?></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table table-sm bg-white text-dark mt-3 shadow">
                                                <thead>
                                                    <tr>
                                                        <th colspan="8">
                                                            Bill Details
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th class="text-center">Bill #</th>
                                                        <th class="text-center">Head</th>

                                                        <th class="text-right">Sales Tax With Held</th>
                                                        <th class="text-right">Income Tax With Held</th>
                                                        <th class="text-right">Adjustment Amount</th>
                                                        <th class="text-right">Paid Amount</th>
                                                        <th class="text-right">Total</th>
                                                    </tr>
                                                </thead>
                                                <?php $stwh = $itwh = $aa = $pa = $t = 0;
                                                if ($row['items']) {
                                                    $c = 1;
                                                    foreach ($row['items'] as $i) {
                                                        $stwh += $i->sales_tax_with_held;
                                                        $itwh += $i->income_tax_with_held;
                                                        $aa += $i->adjustment_amount;
                                                        $pa += $i->paid_amount;
                                                        $t += $i->total;
                                                ?>
                                                        <tr>
                                                            <td class="text-center"><?= $c ?></td>
                                                            <td class="text-center"><?= $i->job_bill->bill_no ?></td>
                                                            <td class="text-center"><?php if($i->account_title_id) $i->account_title->title ?></td>
                                                            <td class="text-right"><?= amount($i->sales_tax_with_held) ?></td>
                                                            <td class="text-right"><?= amount($i->income_tax_with_held) ?></td>
                                                            <td class="text-right"><?= amount($i->adjustment_amount) ?></td>
                                                            <td class="text-right"><?= amount($i->paid_amount) ?></td>
                                                            <td class="text-right"><?= amount($i->total) ?></td>
                                                        </tr>
                                                    <?php $c++;
                                                    } ?>

                                                    <tr class="bg-light shadow">
                                                        <th colspan="3" class="text-right">Total</th>
                                                        <th class="text-right"><?= amount($stwh) ?></th>
                                                        <th class="text-right"><?= amount($itwh) ?></th>
                                                        <th class="text-right"><?= amount($aa) ?></th>
                                                        <th class="text-right"><?= amount($pa) ?></th>
                                                        <th class="text-right"><?= amount($t) ?></th>
                                                    </tr>

                                                <?php
                                                } ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php $c++;
                        }
                    } else {
                        ?>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-danger">Sorry! records not found.</div>
                            </div>
                        </div>

                    <?php
                    }

                    ?>
                </div>
            </div>
        </div>
    </div>




    @section('exfooter')


    <div id="invoice_receipt_modal" class="modal fade" tabindex="-1" role="dialog" id="list">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Invoice Receipt</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Receipt #</th>
                                <th class='text-right'>withholding tax amount</th>
                                <th class='text-right'>adjustment amount</th>
                                <th class='text-right'>instrument amount</th>
                                <th>instrument #</th>
                                <th>payment mode</th>
                                <th>Bank name</th>
                                <th class="text-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody id="modal_receipt_list">
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div id="bill_payments_modal" class="modal fade" tabindex="-1" role="dialog" id="list">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Bill Payment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Payment #</th>
                                <th class='text-right'>withholding tax amount</th>
                                <th class='text-right'>adjustment amount</th>
                                <th class='text-right'>instrument amount</th>
                                <th>instrument #</th>
                                <th>payment mode</th>
                                <th>Bank name</th>
                                <th class="text-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody id="modal_payments_list">
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function getReceipts(id) {

            $.get("/get-job-invoice-receipts/" + id, function(data) {
                $("#modal_receipt_list").html(data);
            });

            showModal("#invoice_receipt_modal");
        }

        function getPayments(id) {

            $.get("/get-job-bill-payments/" + id, function(data) {
                $("#modal_payments_list").html(data);
            });

            showModal("#bill_payments_modal");
        }


        function updateApprovedValue(v) {
            $("#approved").val(v);
        }
    </script>

    @endsection

</x-layout-admin>