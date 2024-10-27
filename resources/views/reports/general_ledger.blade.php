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
                                        <x-combobox of="account_titles" label="G/L Account" ref="account_title_id" inline=0 />
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
                                <h4>General Ledger Report</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover report-datatable table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th width="80" class="text-center"></th>
                                        <th>GL Number</th>
                                        <th>GL Name</th>
                                        <th>Job Number</th>
                                        <th>Job Creation Date</th>
                                        <th>Company Name</th>
                                        <th>Doc Date</th>
                                        <th>Doc Ceated Date</th>
                                        <th>Clearing Date</th>
                                        <th>Clearing Document # (Payment / Receipt if this is the case)</th>
                                        <th>Amount</th>
                                        <th>Amount Offsetting A/C #</th>
                                        <th>Offsetting A/C Name</th>
                                        <th>Reamarks</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</x-layout-admin>