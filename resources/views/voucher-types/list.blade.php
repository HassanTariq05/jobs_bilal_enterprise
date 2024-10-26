    <x-layout-admin>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Job Types</h4>
                            </div>
                            <div class="col-md-6 text-right">
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
                                            <?php /*
                                            <x-action-btn route="voucher-type" id="{{$row->id}}" privilegeEditId="" privilegeDeleteId="" privilegeRestoreId="{{$row->deleted_at ?  : 0}}" />
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