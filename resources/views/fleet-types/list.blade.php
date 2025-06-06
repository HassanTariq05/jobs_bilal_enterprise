    <x-layout-admin>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Fleet Types</h4>
                            </div>
                            <div class="col-md-6 text-right">
                                <?php if (has_permission(222)) { ?>
                                    <a href="{{route('create-fleet-type')}}" class="btn btn-sm btn-primary">Add New</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-sm" id="table-1">
                                <thead>
                                    <tr>
                                        <th width="100" class="text-center">#</th>
                                        <th width="100" class="text-center">Image</th>
                                        <th>Title</th>
                                        <th width="100" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($rows->count())
                                    @foreach($rows as $row)
                                    <tr>
                                        <td class="text-center">{{$loop->iteration}}</td>
                                        <td class="text-center">
                                            <img class="img-fluid x-small-thumbnail" src="{{getFromStorage($row->image)}}" />
                                        </td>
                                        <td>{{$row->title}}</td>
                                        <td class="text-center">
                                            <x-action-btn route="fleet-type" id="{{$row->id}}" privilegeEditId="223" privilegeDeleteId="224" privilegeRestoreId="{{$row->deleted_at ? 225 : 0}}"  />
                                            <?php /*
                                            <a href="{{route('edit-fleet-type', [$row->id])}}" class="btn btn-icon  btn-sm btn-primary"><i class="far fa-edit"></i></a>
                                            <a href="#" class="btn btn-icon  btn-sm btn-danger"><i class="fas fa-times"></i></a>
                                            */ ?>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-layout-admin>