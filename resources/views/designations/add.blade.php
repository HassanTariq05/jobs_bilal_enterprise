<x-layout-admin>
    <div class="row">
        <div class="col-12">
            <form method="post" action="{{route('store-designation')}}" enctype='multipart/form-data'>
                @csrf
                <div class="card">
                    <div class="card-header border-bottom">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Add New</h4>
                            </div>
                            <div class="col-md-6 text-right">
                                <?php if (has_permission(133)) { ?>
                                    <a href="{{route('designations')}}" class="btn btn-sm btn-primary">View All</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
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
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-7">
                                <?php if (has_permission(134)) { ?>
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