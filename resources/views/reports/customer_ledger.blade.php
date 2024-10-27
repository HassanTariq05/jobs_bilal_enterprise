<x-layout-admin>

    <?php if (!isset($_REQUEST['submit'])) { ?>
        <div class="row">
            <div class="col-12">
                <form method="post" action="" enctype='multipart/form-data'>
                    @csrf
                    <div class="card">
                        <div class="card-header border-bottom">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Choose Criteria</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="party_id">Customer</label>
                                        <select class="form-control select2" id="party_id" name="party_id">
                                            <option value="">--select--</option>
                                            @if($customers)
                                            @foreach($customers as $row)
                                            <option value="{{$row->id}}">{{$row->title}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <x-combobox of="companies" label="Company" ref="company_id" inline=0 />
                                </div>
                                <div class="col-md-4">
                                    <x-combobox of="locations" label="Cost Center" ref="location_id" inline=0 />
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="party_id">Status</label>
                                        <select class="form-control select2" id="party_id" name="party_id">
                                            <option value="all">All</option>
                                            <option value="closed">Closed</option>
                                            <option value="opened">Opened</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="date">Date</label>
                                        <input id="date" type="date" class="form-control" name="date" />
                                    </div>
                                </div>
                                <div class="col-md-4 text-right">
                                    <button type="submit" name="submit" value="submit" class="btn btn-primary mt-4">Submit</button>
                                </div>                                
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php } else { ?>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Customer Ledger Report</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover report-datatable table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th width="80" class="text-center">#</th>
                                        <th>Customer ID</th>
                                        <th>Customer Name</th>
                                        <th>Job Number</th>
                                        <th>Job Creation Date</th>
                                        <th>Company Name</th>
                                        <th>Doc Date (Invoice)</th>
                                        <th>Doc Ceated Date (Invoice)</th>
                                        <th>Clearing Date (Receipt)</th>
                                        <th>Clearing Document # (Receipt #) </th>
                                        <th>Amount</th>
                                        <th>Reamarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($rows) {
                                        $c = 1;
                                        foreach ($rows as $row) {
                                    ?>
                                            <tr>
                                                <td><?= $c ?></td>
                                                <td><?= $row->job_invoice->party->id ?></td>
                                                <td><?= $row->job_invoice->party->name ?></td>
                                                <td><?= $row->job_invoice->job->job_no ?></td>
                                                <td><?= $row->job_invoice->job->created_at ?></td>
                                                <td><?= $row->job_invoice->job->company->title ?></td>
                                                <td><?= $row->job_invoice->inv_date ?></td>
                                                <td><?= $row->job_invoice->created_at ?></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                    <?php $c++;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>



    @section('exfooter')
    <script>
        function changeDateCalendar(v) {
            $(".date_container").addClass('hide');
            if (v != '') {
                if (v == 'open') {
                    $(".single_date").removeClass('hide');
                } else {
                    $(".range_date").removeClass('hide');
                }
            }
        }
    </script>
    @endsection

</x-layout-admin>