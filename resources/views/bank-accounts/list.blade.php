    <x-layout-admin>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Bank Accounts</h4>
                            </div>
                            <div class="col-md-6 text-right">
                                <?php if (has_permission(20)) { ?>
                                    <a href="{{route('create-bank-account')}}" class="btn btn-sm btn-primary">Add New</a>
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
                                        <th>Account Title</th>
                                        <th>IBAN</th>
                                        <th>Company</th>
                                        <th>Bank</th>
                                        <th>Bank Address</th>
                                        <th width="100" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($rows->count())
                                    @foreach($rows as $row)
                                    <tr>
                                        <td class="text-center">{{$loop->iteration}}</td>
                                        <td>{{$row->title}}</td>
                                        <td>{{$row->iban}}</td>
                                        <td>{{$row->company->title ?? ''}}</td>
                                        <td>{{$row->bank}}</td>
                                        <td>{{$row->address}}</td>
                                        <td class="text-center">
                                            <x-action-btn route="bank-account" id="{{$row->id}}" privilegeEditId="21" privilegeDeleteId="22" privilegeRestoreId="{{$row->deleted_at ? 23 : 0}}"  />
                                            <?php /*
                                            <a href="{{route('edit-bank-account', [$row->id])}}" class="btn btn-icon  btn-sm btn-primary"><i class="far fa-edit"></i></a>
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