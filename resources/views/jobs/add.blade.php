<x-layout-admin>
    <div class="row">
        <div class="col-12">
            <form method="post" action="{{route('store-job')}}" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header border-bottom">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Add New Job</h4>
                            </div>
                            <div class="col-md-6 text-right">
                                <?php if (has_permission(67)) { ?>
                                    <a href="{{route('jobs')}}" class="btn btn-sm btn-primary">View All</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <x-combobox of="parties" label="Customer" ref="party_id" inline=0 />
                            </div>
                            <div class="col-md-4">
                                <x-combobox of="companies" label="Company" ref="company_id" inline=0 />
                            </div>
                            <div class="col-md-4">
                                <x-combobox of="locations" label="Location" ref="location_id" inline=0 />
                            </div>
                            <div class="col-md-4">
                                <x-combobox of="job_types" label="Job Type" ref="job_type_id" inline=0 />
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="document_date">Document Date</label>
                                    <input type="date" id="document_date" name="document_date" value="{{old('document_date')}}" class="form-control" />
                                    @error('document_date')
                                    <div class="text-danger">required</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="remarks">Remarks</label>
                                    <textarea class="form-control" id="remarks" name="remarks">{{old('remarks')}}</textarea>
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
                        </div>
                    </div>
                    <div class="card-footer border-top">
                        <div class="row">
                            <div class="col-12 text-right">
                                <?php if (has_permission(68)) { ?>
                                    <button class="btn btn-primary">Submit</button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layout-admin>