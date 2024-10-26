<x-layout-admin>
    <div class="row">
        <div class="col-12">
            <form method="post" action="{{route('store-job-invoice', [$id])}}" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header border-bottom">
                        <h4>Add Invoice For : <span class="badge badge-secondary text-white"> Job # {{$job->job_no}} </span></h4>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="job_id" value="{{$id}}" />
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="party_id">Customer</label>
                                    <select class="form-control select2" id="party_id" name="party_id">
                                        <option value="">--select--</option>
                                        @if($customers)
                                        @foreach($customers as $customer)
                                        <option value="{{$customer->id}}">{{$customer->title}}</option>
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
                                    <label for="inv_date">Invoice Date</label>
                                    <input id="inv_date" type="date" class="form-control" name="inv_date">
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
                                <?php if (has_permission(80)) { ?>
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