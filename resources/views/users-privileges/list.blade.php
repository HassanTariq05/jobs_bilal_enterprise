<x-layout-admin>
    <div class="row">
        <div class="col-12">
            <form method="post" action="{{route('update-user-privileges', [Auth::user()->id])}}">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Users Privileges</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($privileges->count())
                        @foreach($privileges as $privilege_cat)
                        <div class="row">
                            <div class="col-12">
                                <div class="card card-primary shadow-none">
                                    <div class="card-header bg-light py-1">
                                        <h4>{{$privilege_cat->title}}</h4>
                                    </div>
                                    <div class="card-body p-2">
                                        @if($privilege_cat->privilege_groups->count())
                                        @foreach($privilege_cat->privilege_groups as $privilege_group)
                                        <div class="row  align-items-center mt-2">
                                            <div class="col-md-4 font-weight-bold">
                                                {{$privilege_group->title}}
                                            </div>
                                            <div class="col-md-8">
                                                @if($privilege_group->privileges->count())
                                                <div class="row">
                                                    @foreach($privilege_group->privileges as $privilege)
                                                    <div class="col-md-3">
                                                        <div data-toggle="tooltip" data-placement="left" title="" data-original-title="{{$privilege->title}} ({{$privilege->id}})" class="custom-control custom-checkbox">
                                                            <input type="checkbox" name="privilege[]" class="custom-control-input" id="{{$privilege->slug}}">
                                                            <label class="custom-control-label" for="{{$privilege->slug}}">{{$privilege->short_title}}</label>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <hr class="my-2" />
                                            </div>
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-primary" type="submit" name="submit">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</x-layout-admin>