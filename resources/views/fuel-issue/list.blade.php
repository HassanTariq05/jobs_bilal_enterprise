<x-layout-admin>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Fuel Issuance</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            <?php if (has_permission(116)) { ?>
                                <a href="{{route('create-fuel-issue')}}" class="btn btn-sm btn-primary">Add New</a>
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
                                    <th>Tank</th>
                                    <th>Fleet</th>
                                    <th>Operation</th>
                                    <th>Driver</th>
                                    <th>Fill Date</th>
                                    <th>Qty</th>
                                    <th>Odometer Reading</th>
                                    <th width="100" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($rows->count())
                                @foreach($rows as $row)
                                <tr>
                                    <td class="text-center">{{$loop->iteration}}</td>
                                    <td>{{$row->tank->title ?? ''}}</td>
                                    <td>{{$row->fleet->registration_number ?? ''}}</td>
                                    <td>{{$row->operation->title ?? ''}}</td>
                                    <td>{{$row->driver}}</td>
                                    <td>{{$row->fill_date}}</td>
                                    <td>{{$row->qty}}</td>
                                    <td>{{$row->odometer_reading}}</td>
                                    <td class="text-center">
                                        <x-action-btn route="fuel-issue" id="{{$row->id}}" privilegeEditId="117" privilegeDeleteId="118" privilegeRestoreId="{{$row->deleted_at ? 119 : 0}}" />
                                        <?php /*
                                        <a href="{{route('edit-fuel-issue', [$row->id])}}" class="btn btn-icon  btn-sm btn-primary"><i class="far fa-edit"></i></a>
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