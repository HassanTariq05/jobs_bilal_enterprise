<x-layout-admin>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>System Users</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            <?php if (has_permission(128)) { ?>
                                <a href="{{route('create-user')}}" class="btn btn-sm btn-primary">Add New</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped data-table">
                            <thead>
                                <tr>
                                    <th width="30" class="text-center">#</th>
                                    <th>User Role</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Designation</th>
                                    <th>Report To</th>
                                    <th class="col-md-2">Remarks</th>
                                    <th width="120" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($rows->count())
                                @foreach($rows as $row)
                                <tr>
                                    <td class="text-center">{{$loop->iteration}}</td>
                                    <td>@if($row->user_role) {{$row->user_role->title ?? ''}} @endif</td>
                                    <td>{{$row->name}}</td>
                                    <td>{{$row->email}}</td>
                                    <td>@if($row->designation) {{$row->designation->title ?? ''}} @endif</td>
                                    <td>{{$row->lead->name}}</td>
                                    <td>{!!$row->remarks!!}</td>
                                    <td class="text-center">
                                        <x-action-btn route="user" id="{{$row->id}}" privilegeEditId="129" privilegeDeleteId="130"  privilegeRestoreId="{{$row->deleted_at ? 131 : 0}}" />
                                        <?php /*
                                        <a href="{{route('edit-user', [$row->id])}}" class="btn btn-icon  btn-sm btn-primary"><i class="far fa-edit"></i></a>
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