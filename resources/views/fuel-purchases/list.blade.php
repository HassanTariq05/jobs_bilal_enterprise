<x-layout-admin>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Fuel Purchases</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            <?php if (has_permission(122)) { ?>
                                <a href="{{route('create-fuel-purchase')}}" class="btn btn-sm btn-primary">Add New</a>
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
                                    <th>Vendor</th>
                                    <th>Fuel type</th>
                                    <th>Tank</th>
                                    <th>Qty</th>
                                    <th>Rate</th>
                                    <th>Amount</th>
                                    <th width="100" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($rows->count())
                                @foreach($rows as $row)
                                <tr>
                                    <td class="text-center">{{$loop->iteration}}</td>
                                    <td>{{$row->party->title ?? ''}}</td>
                                    <td>{{$row->fuel_type->title ?? ''}}</td>
                                    <td>{{$row->tank->title ?? ''}}</td>
                                    <td>{{$row->qty}}</td>
                                    <td>{{$row->rate}}</td>
                                    <td>{{$row->amount}}</td>
                                    <td class="text-center">
                                        <x-action-btn route="fuel-purchase" id="{{$row->id}}" privilegeEditId="123" privilegeDeleteId="124" privilegeRestoreId="{{$row->deleted_at ? 125 : 0}}" />
                                        <?php /*
                                        <a href="{{route('edit-fuel-purchase', [$row->id])}}" class="btn btn-icon  btn-sm btn-primary"><i class="far fa-edit"></i></a>
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