@if($inline)

<div class="form-group row mb-4">
    <label for="fleet_id" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Fleet</label>
    <div class="col-sm-12 col-md-7">
        <select class="form-control selectric" id="fleet_id" name="fleet_id">
            <option value="">--select--</option>
            @if($rows)
            @foreach($rows as $row)
            <option @if(isset($selected) && $selected==$row->id) selected @endif value="{{$row->id}}">{{$row->engine_number}}</option>
            @endforeach
            @endif
        </select>
        @error('fleet_id')
        <div class="text-danger">required</div>
        @enderror
    </div>
</div>

@else

<div class="form-group">
    <label for="fleet_id">Fleet</label>
    <select class="form-control selectric" id="fleet_id" name="fleet_id">
        <option value="">--select--</option>
        @if($rows)
        @foreach($rows as $row)
        <option @if(isset($selected) && $selected==$row->id) selected @endif value="{{$row->id}}">{{$row->registration_number}}</option>
        @endforeach
        @endif
    </select>
    @error('fleet_id')
    <div class="text-danger">required</div>
    @enderror
</div>

@endif