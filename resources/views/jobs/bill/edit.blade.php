<x-layout-admin>

    <div class="row">
        <div class="col-12">
            <form method="post" action="{{route('update-job-bill', [$job->id, $row->id])}}" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header border-bottom">
                        <h4>
                            Edit Bill Information
                        </h4>
                        <?php if (has_permission(38)) { ?>
                            <a href="{{route('create-job-bill-detail', [$job->id, $row->id])}}" class="btn btn-icon rounded-0 btn-sm btn-dark" title="Edit Bill List Items"><i class="fa fa-list"></i></a>
                        <?php } ?>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="job_id" value="{{$job->id}}" />
                        <div class="row">
                            <div class="col-md-4">

                                <div class="form-group">
                                    <label for="Vendor">Vendor</label>
                                    <select class="form-control select2" id="party_id" name="party_id">
                                        <option value="">--select--</option>
                                        @if($vendors)
                                        @foreach($vendors as $vendor)
                                        <option <?php if ($row->party_id == $vendor->id) echo 'selected'; ?> value="{{$vendor->id}}">{{$vendor->title}}</option>
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
                                    <input id="bill_date" type="date" class="form-control" value="{{$row->bill_date}}" name="bill_date">
                                    @error('bill_date')
                                    <div class="text-danger">required</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="due_date">Due Date</label>
                                    <input id="due_date" type="date" class="form-control" name="due_date" value="{{$row->due_date}}">
                                    @error('due_date')
                                    <div class="text-danger">required</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="vendor_ref">Vendor Ref</label>
                                    <input id="vendor_ref" type="text" class="form-control" name="vendor_ref" value="{{$row->vendor_ref}}">
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
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div>
                                        <label class="form-label" for="inputFile">Existing Files:</label>
                                    </div>
                                    <?php if ($row->files) { ?>
                                        <div class="row">
                                            <?php foreach ($row->files as $f) { ?>
                                                <div class="col-md-2 text-center">
                                                    <div class="text-right">
                                                        <a href="" class="fa fa-times text-danger delete-file"></a>
                                                    </div>
                                                    <div>
                                                        <a target="_blank" href="<?= getFromStorage($f->file_path); ?>">
                                                            <img src="<?= asset('assets/img/' . $f->ext . '.png'); ?>" />
                                                        </a>
                                                    </div>
                                                    <div class="title text-center">
                                                        <?= $f->title ?>
                                                    </div>
                                                </div>

                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="remarks">Created on</label>
                                    <div>{{$row->created_at}}</div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <?php if (!$job->approved) { ?>
                        <div class="card-footer border-top">
                            <div class="row">
                                <div class="col-12 text-right">
                                    <?php if (has_permission(33)) { ?>
                                        <button class="btn btn-primary">Submit</button>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </form>
        </div>
    </div>


</x-layout-admin>