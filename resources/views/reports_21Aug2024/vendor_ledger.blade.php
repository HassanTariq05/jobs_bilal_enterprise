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
                                <?php /*
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Vendor ID</label>
                                        <input id="" type="number" class="form-control" name="" />
                                    </div>
                                </div>
                                */ ?>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="party_id">Vendors</label>
                                        <select class="form-control select2" id="party_id" name="party_id">
                                            <option value="">--select--</option>
                                            @if($vendors)
                                            @foreach($vendors as $row)
                                            <option value="{{$row->id}}">{{$row->title}}</option>
                                            @endforeach
                                            @endif
                                        </select>
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
                                        <label for="">Doc Date (Bill)</label>
                                        <input id="" type="date" class="form-control" name="" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Doc Ceated Date (Bill)</label>
                                        <input id="" type="date" class="form-control" name="" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Clearing Date (Payment)</label>
                                        <input id="" type="date" class="form-control" name="" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Clearing Document # (Payment #)</label>
                                        <input id="" type="text" class="form-control" name="" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Vendor Invoice Date</label>
                                        <input id="" type="date" class="form-control" name="" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <x-combobox of="locations" label="Location" ref="location_id" inline=0 />
                                </div>
                                <div class="col-md-3">
                                    <x-combobox of="job_types" label="Job Type" ref="job_type_id" inline=0 />
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
                                <h4>Vendor Ledger Report</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover report-datatable table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th width="80" class="text-center"></th>
                                        <th>Vendor ID</th>
                                        <th>Vendor Name</th>
                                        <th>Job Number</th>
                                        <th>Job Creation Date</th>
                                        <th>Company Name</th>
                                        <th>Doc Date (Bill)</th>
                                        <th>Doc Ceated Date (Bill)</th>
                                        <th>Clearing Date (Payment)</th>
                                        <th>Clearing Document # (Payment #)</th>
                                        <th>Amount</th>
                                        <th>Cheque #</th>
                                        <th>Due Date</th>
                                        <th>Vendor Invoice Date</th>
                                        <th>Location</th>
                                        <th>Job Type</th>
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