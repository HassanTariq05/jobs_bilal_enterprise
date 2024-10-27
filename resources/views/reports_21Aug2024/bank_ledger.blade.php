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
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">GL Name (Bank)</label>
                                        <input id="" type="text" class="form-control" name="" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Job Number</label>
                                        <input id="" type="text" class="form-control" name="" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Job Creation Date</label>
                                        <input id="" type="date" class="form-control" name="" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <x-combobox of="companies" label="Company" ref="company_id" inline=0 />
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Doc Date (Payment / Receipt)</label>
                                        <input id="" type="date" class="form-control" name="" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Doc Ceated Date (Payment / Receipt)</label>
                                        <input id="" type="date" class="form-control" name="" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Clearing Date (Payment / Receipt)</label>
                                        <input id="" type="date" class="form-control" name="" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Clearing Document # (Payment / Receipt #)</label>
                                        <input id="" type="text" class="form-control" name="" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
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
                                <h4>Bank Ledger Report</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover report-datatable table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th width="80" class="text-center"></th>
                                        <th>GL Number (Bank)</th>
                                        <th>GL Name (Bank)</th>
                                        <th>Job Number</th>
                                        <th>Job Creation Date</th>
                                        <th>Company Name</th>
                                        <th>Doc Date (Payment / Receipt)</th>
                                        <th>Doc Ceated Date (Payment / Receipt)</th>
                                        <th>Clearing Date (Payment / Receipt)</th>
                                        <th>Clearing Document # (Payment / Receipt)</th>
                                        <th>Amount</th>
                                        <th>Instrument #</th>
                                        <th>Bank Name - Receipt / Payment</th>
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