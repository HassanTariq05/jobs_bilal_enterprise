<x-layout-admin>
    <div class="row">
        <div class="col-12">
            <form method="post" action="{{route('update-actor', [$row->id])}}" enctype='multipart/form-data'>
                @csrf
                <div class="card">
                    <div class="card-header border-bottom">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Edit Actor</h4>
                            </div>
                            <div class="col-md-6 text-right">
                                <?php if (has_permission(25)) { ?>
                                    <a href="{{route('actors')}}" class="btn btn-sm btn-primary">View All</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body">
                    <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">First Name</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" id="first_name" name="first_name" value="{{$row->first_name}}" class="form-control" />
                                @error('first_name')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Last Name</label>
                            <div class="col-sm-12 col-md-4">
                                <input type="text" id="last_name" name="last_name" value="{{$row->last_name}}" class="form-control" />
                                @error('last_name')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Bio</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" id="bio" name="bio" value="{{$row->bio}}" class="form-control" />
                                @error('bio')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                        
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">DOB</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="date" id="dob" name="dob" value="{{$row->dob}}" class="form-control" />
                                @error('dob')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                            

                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-7">
                                <?php if (has_permission(27)) { ?>
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