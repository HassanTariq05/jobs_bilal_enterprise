<x-layout-admin>
    <div class="row">
        <div class="col-12">
            <form method="post" action="{{route('update-project', [$row->id])}}">
                @csrf
                <div class="card">
                    <div class="card-header border-bottom">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Edit</h4>
                            </div>
                            <div class="col-md-6 text-right">
                                <?php if (has_permission(173)) { ?>
                                    <a href="{{route('projects')}}" class="btn btn-sm btn-primary">View All</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Title</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" id="title" name="title" value="{{$row->title}}" class="form-control" />
                                @error('title')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Short Name</label>
                            <div class="col-sm-12 col-md-4">
                                <input type="text" id="short_name" name="short_name" value="{{$row->short_name}}" class="form-control" />
                                @error('short_name')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-7">
                                <?php if (has_permission(175)) { ?>
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