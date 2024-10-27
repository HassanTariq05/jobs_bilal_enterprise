<x-layout-admin>


    <div class="row">
        <div class="col-12">
            <form method="post" action="{{route('update-tank', [$row->id])}}">
                @csrf
                <div class="card">
                    <div class="card-header border-bottom">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Edit</h4>
                            </div>
                            <div class="col-md-6 text-right">
                                <?php if (has_permission(209)) { ?>
                                    <a href="{{route('tanks')}}" class="btn btn-sm btn-primary">View All</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <x-combobox of="fuel_types" label="Fuel Type" ref="fuel_type_id" inline=0 selected="{{$row->fuel_type_id}}" />
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">Tank Name</label>
                                    <input type="text" id="title" name="title" value="{{$row->title}}" class="form-control" />
                                    @error('title')
                                    <div class="text-danger">required</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <x-combo-users selected="{{$row->user_id}}" label="Supervisor" ref="user_id" />
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="location">Tank Location</label>
                                    <input type="text" id="location" name="location" value="{{$row->location}}" class="form-control" />
                                    @error('location')
                                    <div class="text-danger">required</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="capacity">Capacity Volume</label>
                                <div class="input-group mb-3">
                                    <input type="number" id="capacity" name="capacity" value="{{$row->capacity}}" class="form-control" />
                                    <span class="input-group-text" id="basic-addon2">Ltr.</span>
                                </div>
                                @error('capacity')
                                <div class="text-danger">required</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="remarks">Reamrks</label>
                                    <textarea id="remarks" name="remarks" class="form-control summernote-simple">{{$row->remarks}}</textarea>
                                    @error('remarks')
                                    <div class="text-danger">required</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer border-top">
                        <div class="row">
                            <div class="col-12 text-right">
                                <?php if (has_permission(211)) { ?>
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