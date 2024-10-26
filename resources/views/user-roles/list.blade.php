    <x-layout-admin>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>User Roles</h4>
                            </div>
                            <div class="col-md-6 text-right">
                                <?php if (has_permission(140)) { ?>
                                    <a href="{{route('create-user-role')}}" class="btn btn-sm btn-primary">Add New</a>
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
                                        <th>Title</th>
                                        <th width="100" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($rows->count())
                                    @foreach($rows as $row)
                                    <tr>
                                        <td class="text-center">{{$loop->iteration}}</td>
                                        <td>{{$row->title}}</td>
                                        <td class="text-center">
                                            <?php if (has_permission(157)) { ?>
                                                <a href="{{route('role-privileges', [$row->id])}}" data-toggle="tooltip" data-placement="left" title="" data-original-title="User Privileges" class="btn btn-icon  btn-sm btn-primary"><i class="fas fa-moon"></i></a>
                                            <?php } ?>
                                            <x-action-btn route="user-role" id="{{$row->id}}" privilegeEditId="141" privilegeDeleteId="142"  privilegeRestoreId="{{$row->deleted_at ? 143 : 0}}" />
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