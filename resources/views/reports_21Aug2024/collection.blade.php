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
                                <div class="col-md-3 hide">
                                    <div class="form-group">
                                        <label for="">Document Number (Receipt#)</label>
                                        <input id=""  type="number" class="form-control" name="" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Document Date</label>
                                        <input id="" type="date" class="form-control" name="" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Document Created Date</label>
                                        <input id="" type="date" class="form-control" name="" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Instrument Date</label>
                                        <input id="" type="date" class="form-control" name="" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <x-combobox of="companies" label="Company" ref="company_id" inline=0 />
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Instrument #</label>
                                        <input id="" type="text" class="form-control" name="" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <x-combobox of="banks" label="Bank" ref="bank_id" inline=0 />
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
                            <h4>Collection Report</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover report-datatable table-striped table-sm">
                            <thead>
                                <tr>
                                    <th width="80" class="text-center"></th>
                                    <th>Document Number (Receipt#)</th>
                                    <th>Doc Date</th>
                                    <th>Doc Created Date</th>
                                    <th>Instrument Date</th>
                                    <th>Company Name</th>
                                    <th>Instrument #</th>
                                    <th>Bank Name</th>
                                    <th>Amuont</th>
                                    <th>Balance</th>
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