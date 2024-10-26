<x-layout-admin>

    <form method="post" action="{{route('search')}}">
        @csrf
        <div class="row">

            <div class="col-12">
                <div class="card border">
                    <div class="card-header" style="padding-top: 5px !important;padding-bottom: 5px !important;">
                        <h4>Search Filters - <i class="fa fa-eye text-primary" data-toggle="collapse" data-target="#search-form-container"></i></h4>
                    </div>
                    <div id="accordion">
                        <div class="accordion m-0">
                            <div class="accordion-body collapse" id="search-form-container" data-parent="#accordion">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="job_no">Job #</label>
                                            <input type="text" id="job_no" name="job_no" value="{{request()->input('job_no')}}" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Document Date</label>
                                            <div class="input-group">
                                                <input type="text" name="document_date" class="form-control daterange">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <x-combobox of="parties" label="Party" ref="party_id" inline=0 selected="{{request()->input('party_id')}}" />
                                    </div>
                                    <div class="col-md-4">
                                        <x-combobox of="companies" autofocus="true" label="Company" ref="company_id" inline=0 selected="{{request()->input('company_id')}}" />
                                    </div>
                                    <div class="col-md-4">
                                        <x-combobox of="parties" label="Vendor" ref="vendor_id" inline=0 selected="{{request()->input('vendor_id')}}" />
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-right mt-4 mb-3">
                                            <a href="/jobs" class="btn btn-danger">Refresh</a>
                                            <button class="btn btn-success text-dark" name="search" value="search">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-md-6">
            <nav>
                <div class="nav nav-tabs border-0 nav-justified" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-open-tab" data-toggle="tab" data-target="#nav-open" type="button" role="tab" aria-controls="nav-open" aria-selected="true">
                        Open Jobs
                    </button>
                    <button class="nav-link" id="nav-closed-tab" data-toggle="tab" data-target="#nav-closed" type="button" role="tab" aria-controls="nav-closed" aria-selected="false">
                        Closed Jobs
                    </button>
                </div>
            </nav>
        </div>
        <div class="col-md-6 text-right">
            <a href="{{route('create-job')}}" class="btn btn-sm btn-primary">Add New Job</a>
        </div>
        <div class="col-12">
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-open" role="tabpanel" aria-labelledby="nav-open-tab">

                    <div class="card">
                        <div class="card-body">
                            <table class="table table-hover table-striped table-sm data-table">
                                <thead>
                                    <tr>
                                        <th width="40" class="text-center">#</th>
                                        <th class="text-center">Job #</th>
                                        <th class="text-center">Doc Date</th>
                                        <th>Party</th>
                                        <th>Nature</th>
                                        <th>Company Name</th>
                                        <th>Revenue</th>
                                        <th>Expense</th>
                                        <th>Net Profit</th>
                                        <th width="100" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $total_receivables = $total_payables = $total_profit = 0;
                                    ?>
                                    @if(COUNT($open_jobs))
                                    @foreach($open_jobs as $row)
                                    <?php
                                    $jt = $row->job_totals();
                                    $net = $jt['receivable'] - $jt['payable'];
                                    
                                    $total_receivables += $jt['receivable'];
                                    $total_payables += $jt['payable'];
                                    $total_profit += $net;
                                    ?>
                                    <tr class="<?php if ($row->approved) echo 'bg-success text-white'; ?>">
                                        <td class="text-center">{{$loop->iteration}}</td>
                                        <td class="text-center">{{$row->job_no}}</td>
                                        <td class="text-center">{{$row->document_date}}</td>
                                        <td>{{$row->party->title}}</td>
                                        <td>{{$row->job_type->title}}</td>
                                        <td>{{$row->company->title}}</td>
                                        <td class="text-right">@money($jt['receivable'])</td>
                                        <td class="text-right">@money($jt['payable'])</td>
                                        <td class="text-right">@money($net)</td>
                                        <td class="text-center">

                                            <?php if ($row->approved) { ?>
                                                <a href="{{route('edit-job', [$row->id])}}" class="btn btn-icon  btn-sm btn-dark">
                                                    <i class="far fa-eye"></i>
                                                </a>
                                            <?php } else { ?>
                                                <a href="{{route('edit-job', [$row->id])}}" class="btn btn-icon  btn-sm btn-primary">
                                                    <i class="far fa-edit"></i>
                                                </a>
                                                <a href="#" class="btn btn-icon  btn-sm btn-danger">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            <?php } ?>

                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-right" colspan="6">Total</th>
                                        <th class="text-right">Rs.<?= amount($total_receivables) ?></th>
                                        <th class="text-right">Rs.<?= amount($total_payables) ?></th>
                                        <th class="text-right">Rs.<?= amount($total_profit) ?></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="tab-pane fade" id="nav-closed" role="tabpanel" aria-labelledby="nav-closed-tab">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-hover table-striped table-sm data-table">
                                <thead>
                                    <tr>
                                        <th width="40" class="text-center">#</th>
                                        <th class="text-center">Job #</th>
                                        <th class="text-center">Doc Date</th>
                                        <th>Party</th>
                                        <th>Nature</th>
                                        <th>Company Name</th>
                                        <th>Receivable</th>
                                        <th>Payable</th>
                                        <th>Net Profit</th>
                                        <th width="100" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                    $total_receivables = $total_payables = $total_profit = 0;
                                    ?>
                                    @if(COUNT($closed_jobs))
                                    @foreach($closed_jobs as $row)
                                    <?php
                                    $jt = $row->job_totals();
                                    $net = $jt['receivable'] - $jt['payable'];

                                    $total_receivables += $jt['receivable'];
                                    $total_payables += $jt['payable'];
                                    $total_profit += $net;
                                    ?>
                                    <tr>
                                        <td class="text-center">{{$loop->iteration}}</td>
                                        <td class="text-center">{{$row->job_no}}</td>
                                        <td class="text-center">{{$row->document_date}}</td>
                                        <td>{{$row->party->title}}</td>
                                        <td>{{$row->job_type->title}}</td>
                                        <td>{{$row->company->title}}</td>
                                        <td class="text-right">@money($jt['receivable'])</td>
                                        <td class="text-right">@money($jt['payable'])</td>
                                        <td class="text-right">@money($net)</td>
                                        <td class="text-center">
                                            <a href="{{route('edit-job', [$row->id])}}" class="btn btn-icon  btn-sm btn-primary"><i class="far fa-edit"></i></a>
                                            <a href="#" class="btn btn-icon  btn-sm btn-danger"><i class="fas fa-times"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-right" colspan="6">Total</th>
                                        <th class="text-right">Rs.<?= amount($total_receivables) ?></th>
                                        <th class="text-right">Rs.<?= amount($total_payables) ?></th>
                                        <th class="text-right">Rs.<?= amount($total_profit) ?></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layout-admin>