<x-layout-admin>
    <div class="row">
        <div class="col-12">
            <form method="post" action="{{route('update-bank-account', [$row->id])}}" enctype='multipart/form-data'>
                @csrf
                <div class="card">
                    <div class="card-header border-bottom">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Bank Account Edit</h4>
                            </div>
                            <div class="col-md-6 text-right">
                                <?php if (has_permission(19)) { ?>
                                    <a href="{{route('bank-accounts')}}" class="btn btn-sm btn-primary">View All</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">


                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Bank</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" id="bank" name="bank" value="{{$row->bank}}" class="form-control" />
                                @error('bank')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Bank Address</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" id="address" name="address" value="{{$row->address}}" class="form-control" />
                                @error('address')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Account title</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" id="title" name="title" value="{{$row->title}}" class="form-control" />
                                @error('title')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">IBAN</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" id="iban" name="iban" value="{{$row->iban}}" class="form-control" />
                                @error('iban')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <x-combobox of="companies" label="Company" selected="{{$row->company_id}}" ref="company_id" inline=1 />

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-7">
                                <?php if (has_permission(21)) { ?>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layout-admin>