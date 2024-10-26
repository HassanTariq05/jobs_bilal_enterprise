<x-layout-admin>
    <div class="row">
        <div class="col-12">
            <form method="post" action="{{route('store-fleet')}}" enctype='multipart/form-data'>
                @csrf
                <div class="card">
                    <div class="card-header border-bottom">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Add New</h4>
                            </div>
                            <div class="col-md-6 text-right">
                                <?php if (has_permission(149)) { ?>
                                    <a href="{{route('fleets')}}" class="btn btn-sm btn-primary">View All</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <x-combobox of="fleet_manufacturers" label="Fleet Manufacturer" ref="fleet_manufacturer_id" inline=0 />
                            </div>
                            <div class="col-md-6">
                                <x-combobox of="fleet_types" label="Fleet Type" ref="fleet_type_id" inline=0 />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="registration_number">Registration #</label>
                                    <input type="text" id="registration_number" name="registration_number" value="{{old('registration_number')}}" class="form-control" />
                                    @error('registration_number')
                                    <div class="text-danger">required</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="chassis_number">Chassis #</label>
                                    <input type="text" id="chassis_number" name="chassis_number" value="{{old('chassis_number')}}" class="form-control" />
                                    @error('chassis_number')
                                    <div class="text-danger">required</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="engine_number">Engine #</label>
                                    <input type="text" id="engine_number" name="engine_number" value="{{old('engine_number')}}" class="form-control" />
                                    @error('engine_number')
                                    <div class="text-danger">required</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="model">Model</label>
                                    <input type="text" id="model" name="model" value="{{old('model')}}" class="form-control" />
                                    @error('model')
                                    <div class="text-danger">required</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="horsepower">Horsepower</label>
                                    <input type="text" id="horsepower" name="horsepower" value="{{old('horsepower')}}" class="form-control" />
                                    @error('horsepower')
                                    <div class="text-danger">required</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="loading_capacity">Loading Capacity</label>
                                    <input type="text" id="loading_capacity" name="loading_capacity" value="{{old('loading_capacity')}}" class="form-control" />
                                    @error('loading_capacity')
                                    <div class="text-danger">required</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="registration_city">Registration City</label>
                                    <input type="text" id="registration_city" name="registration_city" value="{{old('registration_city')}}" class="form-control" />
                                    @error('registration_city')
                                    <div class="text-danger">required</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ownership">Ownership</label>
                                    <input type="text" id="ownership" name="ownership" value="{{old('ownership')}}" class="form-control" />
                                    @error('ownership')
                                    <div class="text-danger">required</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lifting_capacity">Lifting Capacity</label>
                                    <input type="text" id="lifting_capacity" name="lifting_capacity" value="{{old('lifting_capacity')}}" class="form-control" />
                                    @error('lifting_capacity')
                                    <div class="text-danger">required</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="diesel_opening_inventory">Diesel Opening Inventory</label>
                                    <input type="text" id="diesel_opening_inventory" name="diesel_opening_inventory" value="{{old('diesel_opening_inventory')}}" class="form-control" />
                                    @error('diesel_opening_inventory')
                                    <div class="text-danger">required</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <?php /*
                        <div class="row">
                            <div class="col-12">
                                <hr />
                            </div>
                            <div class="col-12">
                                <h5>Media Files</h5>
                            </div>
                            <div class="col-12">
                                <div class="dropzone" id="mydropzone">
                                    <div class="fallback">
                                        <input name="file" type="file" multiple />
                                    </div>
                                </div>
                            </div>
                        </div>
                        */ ?>
                    </div>
                    <div class="card-footer border-top">
                        <div class="row">
                            <div class="col-12 text-right">
                                <?php if (has_permission(150)) { ?>
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