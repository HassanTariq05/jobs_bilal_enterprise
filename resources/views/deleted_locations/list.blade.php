    <x-layout-admin>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Locations</h4>
                            </div>
                            <div class="col-md-6 text-right">
                                <a href="{{route('create-location')}}" class="btn btn-sm btn-primary">Add New</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-sm" id="table-1">
                                <thead>
                                    <tr>
                                        <th width="100" class="text-center">ID</th>
                                        <th>Title</th>
                                        <th width="100" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        @if($rows)
                                        @foreach($rows as $row)
                                    <tr>
                                        <td class="text-center">{{$row->id}}</td>
                                        <td>{{$row->title}}</td>
                                        <td class="text-center">
                                            <a href="{{route('edit-location', [$row->id])}}" class="btn btn-icon  btn-sm btn-primary"><i class="far fa-edit"></i></a>
                                            <a href="#" class="btn btn-icon  btn-sm btn-danger"><i class="fas fa-times"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-layout-admin>