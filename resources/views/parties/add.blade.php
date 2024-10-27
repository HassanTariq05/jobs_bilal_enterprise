<x-layout-admin>
    <div class="row">
        <div class="col-12">
            <form method="post" action="{{route('store-party')}}" enctype='multipart/form-data'>
                @csrf
                <div class="card">
                    <div class="card-header border-bottom">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Add New</h4>
                            </div>
                            <div class="col-md-6 text-right">
                                <?php if (has_permission(197)) { ?>
                                    <a href="{{route('parties')}}" class="btn btn-sm btn-primary">View All</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">


                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Party Types</label>
                            <div class="col-sm-12 col-md-7">
                                <?php if (COUNT($party_types)) { ?>
                                    <div class="row  align-items-center">
                                        <?php foreach ($party_types as $party_type) { ?>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="party_type_id[]" value="<?= $party_type->id; ?>" id="<?= $party_type->title; ?>">
                                                    <label class="form-check-label" for="<?= $party_type->title; ?>">
                                                        <?= $party_type->title; ?>
                                                    </label>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    @error('title')
                                    <div class="text-danger">Please select party type.</div>
                                    @enderror
                                <?php } else { ?>
                                    <div class="alert alert-danger">
                                        Please first <a href="#">add party type</a> to add Party.
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Title</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" id="title" name="title" value="{{old('title')}}" class="form-control" />
                                @error('title')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Short Name</label>
                            <div class="col-sm-12 col-md-4">
                                <input type="text" id="short_name" name="short_name" value="{{old('short_name')}}" class="form-control" />
                                @error('short_name')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Address</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" id="address" name="address" value="{{old('address')}}" class="form-control" />
                                @error('address')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Contact</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" id="contact" name="contact" value="{{old('contact')}}" class="form-control" />
                                @error('contact')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Email</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="email" id="email" name="email" value="{{old('email')}}" class="form-control" />
                                @error('email')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Contact Person</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" id="contact_person" name="contact_person" value="{{old('contact_person')}}" class="form-control" />
                                @error('contact_person')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Bank Name</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" id="bank_name" name="bank_name" value="{{old('bank_name')}}" class="form-control" />
                                @error('bank_name')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">IBAN</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" id="iban" name="iban" value="{{old('iban')}}" class="form-control" />
                                @error('iban')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">NTN</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" id="ntn" name="ntn" value="{{old('ntn')}}" class="form-control" />
                                @error('ntn')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-7">
                                <?php if (has_permission(198)) { ?>
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