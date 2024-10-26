@if($inline)

<div class="form-group row mb-4">
    <label for="{{$ref}}" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{$label}}</label>
    <div class="col-sm-12 col-md-7">
        <select class="form-control selectric" id="{{$ref}}" name="{{$ref}}">
            <option value="">--select--</option>
            @if($rows)
            @foreach($rows as $row)
            <option @if(isset($selected) && $selected==$row->id) selected @endif value="{{$row->id}}">{{$row->name}}</option>
            @endforeach
            @endif
        </select>
        @error($ref)
        <div class="text-danger">required</div>
        @enderror
    </div>
</div>

@else

<div class="form-group">
    <label for="{{$ref}}">{{$label}}</label>
    <select class="form-control selectric" id="{{$ref}}" name="{{$ref}}">
        <option value="">--select--</option>
        @if($rows)
        @foreach($rows as $row)
        <option @if(isset($selected) && $selected==$row->id) selected @endif value="{{$row->id}}">{{$row->name}}</option>
        @endforeach
        @endif
    </select>
    @error($ref)
    <div class="text-danger">required</div>
    @enderror
</div>

@endif