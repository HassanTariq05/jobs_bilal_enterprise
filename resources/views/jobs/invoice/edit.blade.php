<x-layout-admin>

    <div class="row">
        <div class="col-12">
            <form method="post" action="{{route('update-job-invoice', [$job->id, $row->id])}}" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header border-bottom">
                        <h4>
                            Edit Invoice Information
                            <?php if (has_permission(86)) { ?>
                                <a href="{{route('create-job-invoice-detail', [$job->id, $row->id])}}" class="btn btn-icon rounded-0 btn-sm btn-dark ml-3" title="Add/Edit Invoice List Items"><i class="fa fa-list"></i></a>
                            <?php } ?>
                        </h4>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="job_id" value="{{$job->id}}" />
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="party_id">Customer</label>
                                    <select class="form-control select2" id="party_id" name="party_id">
                                        <option value="">--select--</option>
                                        @if($customers)
                                        @foreach($customers as $customer)
                                        <option <?php if ($row->party_id == $customer->id) echo 'selected'; ?> value="{{$customer->id}}">{{$customer->title}}</option>
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
                                    <input id="inv_date" type="date" class="form-control" value="{{$row->inv_date}}" name="inv_date">
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
                                    <?php if (has_permission(81)) { ?>
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