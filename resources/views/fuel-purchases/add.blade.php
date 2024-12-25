<x-layout-admin>
    <div class="row">
        <div class="col-12">
            <form method="post" action="{{route('store-fuel-purchase')}}">
                @csrf
                <div class="card">
                    <div class="card-header border-bottom">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Add New</h4>
                            </div>
                            <div class="col-md-6 text-right">
                                <?php if (has_permission(121)) { ?>
                                    <a href="{{route('fuel-purchases')}}" class="btn btn-sm btn-primary">View All</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="{{ $ref }}">{{ $label }}</label>
                                    <select class="form-control select2" id="{{ $ref }}" name="{{ $ref }}" {{ $autofocus ? 'autofocus' : '' }} style="width:100%">
                                        <option value="">--select--</option>
                                        @foreach($vendors as $vendor)
                                            <option 
                                                value="{{ $vendor->id }}" 
                                                @if(isset($selected) && $selected == $vendor->id) selected @endif>
                                                {{ $vendor->title ?? $vendor->name ?? 'N/A' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error($ref)
                                    <div class="text-danger">required</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <x-combobox of="fuel_types" label="Fuel Type" ref="fuel_type_id" inline=0 />
                            </div>
                            <div class="col-md-6">
                                <x-combobox of="tanks" label="Tank" ref="tank_id" inline=0 />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="qty">Qty</label>
                                    <input type="number" id="qty" name="qty" onkeyup="calculate_amount_by_rate_qty();" value="{{old('qty')}}" class="form-control qty float" />
                                    @error('qty')
                                    <div class="text-danger">required</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="rate">Rate</label>
                                    <input type="string" id="rate" name="rate" onkeyup="calculate_amount_by_rate_qty();" value="{{old('rate')}}" class="form-control rate float" />
                                    @error('rate')
                                    <div class="text-danger">required</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="amount">Amount</label>
                                    <input type="text" id="amount" name="amount" value="{{old('amount')}}"  readonly class="form-control amount float" />
                                    @error('amount')
                                    <div class="text-danger">required</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="delivery_date">Delivery Date</label>
                                    <input type="date" id="delivery_date" name="delivery_date" value="{{old('delivery_date')}}" class="form-control" />
                                    @error('delivery_date')
                                    <div class="text-danger">required</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="freight_charges">Freight Charges</label>
                                    <input type="string" id="freight_charges" name="freight_charges" value="{{old('freight_charges')}}" class="form-control float" />
                                    @error('freight_charges')
                                    <div class="text-danger">required</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="remarks">Reamrks</label>
                                    <textarea id="remarks" name="remarks" class="form-control summernote-simple">{{old('remarks')}}</textarea>
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
                                <?php if (has_permission(122)) { ?>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#{{ $ref }}').select2();
    });
</script>
