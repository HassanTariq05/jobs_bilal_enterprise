<x-layout-admin>
    <div class="row">
        <div class="col-12">
            <form method="post" action="{{route('update-fuel-issue', [$row->id])}}">
                @csrf
                <div class="card">
                    <div class="card-header border-bottom">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Edit</h4>
                            </div>
                            <div class="col-md-6 text-right">
                                <?php if (has_permission(115)) { ?>
                                    <a href="{{route('fuel-issue')}}" class="btn btn-sm btn-primary">View All</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <x-combobox of="tanks" label="Tank" ref="tank_id" inline=0 selected="{{$row->tank_id}}" />
                            </div>
                            <div class="col-md-4">
                                <x-combo-fleet inline=0 selected="{{$row->fleet_id}}" />
                            </div>
                            <div class="col-md-4">
                                <x-combobox of="operations" label="Operation" ref="operation_id" inline=0 selected="{{$row->operation_id}}" />
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fill_date">Fill Date</label>
                                    <input type="date" id="fill_date" name="fill_date" value="{{$row->fill_date}}" class="form-control" />
                                    @error('fill_date')
                                    <div class="text-danger">required</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="qty">Qty</label>
                                    <input type="number" id="qty" name="qty" value="{{$row->qty}}" class="form-control" />
                                    @error('qty')
                                    <div class="text-danger">required</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="driver">Driver</label>
                                    <input type="text" id="driver" name="driver" value="{{$row->driver}}" class="form-control" />
                                    @error('driver')
                                    <div class="text-danger">required</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="odometer_reading">Odometer Reading</label>
                                    <input type="text" id="odometer_reading" name="odometer_reading" value="{{$row->odometer_reading}}" class="form-control float" />
                                    @error('odometer_reading')
                                    <div class="text-danger">required</div>
                                    @enderror
                                </div>
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
                            <?php if (has_permission(117)) { ?>
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