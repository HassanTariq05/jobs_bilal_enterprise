<x-layout-admin>
    <div class="row">
        <div class="col-12">
            <form method="post" action="{{route('store-job-bill', [$job->id])}}" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header border-bottom">
                        <h4>Add Bill For : <span class="badge badge-secondary text-white"> Job # {{$job->job_no}} </span></h4>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="job_id" value="{{$job->id}}" />
                        <div class="row">
                            <div class="col-md-4">

                                <div class="form-group">
                                    <label for="party_id">Vendor</label>
                                    <select class="form-control select2" id="party_id" name="party_id">
                                        <option value="">--select--</option>
                                        @if($vendors)
                                        @foreach($vendors as $vendor)
                                        <option value="{{$vendor->id}}">{{$vendor->title}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @error('party_id')
                                    <div class="text-danger">required</div>
                                    @enderror
                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="bill_date">Bill Date</label>
                                    <input id="bill_date" type="date" class="form-control" name="bill_date" value="{{old('bill_date')}}" />
                                    @error('bill_date')
                                    <div class="text-danger">required</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="due_date">Due Date</label>
                                    <input id="due_date" type="date" class="form-control" name="due_date" value="{{old('due_date')}}" />
                                    @error('due_date')
                                    <div class="text-danger">required</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="vendor_ref">Vendor Ref</label>
                                    <input id="vendor_ref" type="text" class="form-control" name="vendor_ref" value="{{old('vendor_ref')}}" />
                                    @error('vendor_ref')
                                    <div class="text-danger">required</div>
                                    @enderror
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
                                <?php if (has_permission(32)) { ?>
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