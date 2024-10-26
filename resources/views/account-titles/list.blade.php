    <x-layout-admin>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Chart of Accounts</h4>
                            </div>
                            <div class="col-md-6 text-right">
                                <?php if (has_permission(8)) { ?>
                                    <a href="{{route('create-account-title')}}" class="btn btn-sm btn-primary">Add New</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-sm data-table" id="table-1">
                                <thead>
                                    <tr>
                                        <th width="100" class="text-center">#</th>
                                        <!-- <th width="150">Code</th> -->
                                        <th>Nature of Account</th>
                                        <th>Title</th>
                                        <th>Short Name</th>
                                        <th width="100" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($rows->count())
                                    @foreach($rows as $row)
                                    <tr>
                                        <td class="text-center">{{$loop->iteration}}</td>
                                        <!-- <td>{{$row->code}}</td> -->
                                        <td>{{$row->account_nature->title ?? ''}}</td>
                                        <td>{{$row->title}}</td>
                                        <td>{{$row->short_name}}</td>
                                        <td class="text-center">
                                            <x-action-btn route="account-title" id="{{$row->id}}" privilegeEditId="9" privilegeDeleteId="10" privilegeRestoreId="{{$row->deleted_at ? 11 : 0}}" />
                                            <?php /*
                                            <a href="{{route('edit-account-title', [$row->id])}}" class="btn btn-icon  btn-sm btn-primary"><i class="far fa-edit"></i></a>
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