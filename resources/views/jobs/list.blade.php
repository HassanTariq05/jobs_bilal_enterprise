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

    <?php

    //  echo "<pre>"; print_r($rows);

    ?>

    <div class="row">
        <?php if (COUNT($rows)) { ?>
            <div class="col-md-6">
                <nav>
                    <div class="nav nav-tabs border-0 nav-justified" id="nav-tab" role="tablist">
                        <?php $c = 1;
                        foreach ($rows as $row) { ?>
                            <button class="nav-link  <?php if ($c < 2) echo 'active' ?>" id="nav-<?= $row->id ?>-tab" data-toggle="tab" data-target="#nav-<?= $row->id ?>" type="button" role="tab" aria-controls="nav-<?= $row->id ?>" aria-selected="true">
                                <?= $row->title ?>
                            </button>
                        <?php $c++;
                        } ?>
                    </div>
                </nav>
            </div>
            <div class="col-md-6 text-right">
                <?php if (has_permission(68)) { ?>
                    <a href="{{route('create-job')}}" class="btn btn-sm btn-primary">Add New Job</a>
                <?php } ?>
            </div>
            <div class="col-12">
                <div class="tab-content" id="nav-tabContent">
                    <?php $c = 1;
                    foreach ($rows as $row) { ?>
                        <div class="tab-pane fade <?php if ($c < 2) echo 'show active' ?> " id="nav-<?= $row->id ?>" role="tabpanel" aria-labelledby="nav-<?= $row->id ?>-tab">
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
                                            @if($row->jobs)
                                            @foreach($row->jobs as $job)
                                            <?php
                                            $jt = $job->job_totals();
                                            $net = $jt['receivable'] - $jt['payable'];

                                            $total_receivables += $jt['receivable'];
                                            $total_payables += $jt['payable'];
                                            $total_profit += $net;
                                            ?>
                                            <tr class="<?php if ($job->approved) echo 'bg-success text-white'; ?>">
                                                <td class="text-center">{{$loop->iteration}}</td>
                                                <td class="text-center">{{$job->job_no}}</td>
                                                <td class="text-center">{{$job->document_date}}</td>
                                                <td>{{$job->party->title ?? ''}}</td>
                                                <td>{{$job->job_type->title ?? ''}}</td>
                                                <td>{{$job->company->title ?? ''}}</td>
                                                <td class="text-right">@money($jt['receivable'])</td>
                                                <td class="text-right">@money($jt['payable'])</td>
                                                <td class="text-right">@money($net)</td>
                                                <td class="text-center">

                                                    <?php if ($c < 2) { ?>
                                                        <?php if ($job->approved) { ?>
                                                            <a href="{{route('edit-job', [$job->id])}}" class="btn btn-icon  btn-sm btn-dark">
                                                                <i class="far fa-eye"></i>
                                                            </a>
                                                        <?php } else { ?>
                                                            <x-action-btn route="job" id="{{$job->id}}" privilegeEditId=69 privilegeDeleteId=70  privilegeRestoreId="{{$row->deleted_at ? 71 : 0}}" />
                                                        <?php } ?>
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
                    <?php $c++;
                    } ?>
                </div>
            </div>
        <?php } else { ?>
            <div class="col-md-12">
                <div class="alert alert-danger">Sorry! records not found.</div>
            </div>
        <?php } ?>
    </div>

</x-layout-admin>