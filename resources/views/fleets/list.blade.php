<x-layout-admin>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Fleets</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            <?php if (has_permission(150)) { ?>
                                <a href="{{route('create-fleet')}}" class="btn btn-sm btn-primary">Add New</a>
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
                                    <th>Manufacturer</th>
                                    <th>Fleet Type</th>
                                    <th>Registration #</th>
                                    <th>Chassis #</th>
                                    <th>Engine #</th>
                                    <th>Model</th>
                                    <th>Loading Capacity</th>
                                    <th>Lifting Capacity</th>
                                    <th width="100" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($rows->count())
                                @foreach($rows as $row)
                                <tr>
                                    <td class="text-center">{{$loop->iteration}}</td>
                                    <td>{{$row->fleetManufacturer->title ?? ''}}</td>
                                    <td>{{$row->fleetType->title ?? ''}}</td>
                                    <td>{{$row->registration_number}}</td>
                                    <td>{{$row->chassis_number}}</td>
                                    <td>{{$row->engine_number}}</td>
                                    <td>{{$row->model}}</td>
                                    <td>{{$row->loading_capacity}}</td>
                                    <td>{{$row->lifting_capacity}}</td>
                                    <td class="text-center">
                                        <x-action-btn route="fleet" id="{{$row->id}}" privilegeEditId="151" privilegeDeleteId="152" privilegeRestoreId="{{$row->deleted_at ? 153 : 0}}" />
                                        <?php /*
                                        <a href="{{route('edit-fleet', [$row->id])}}" class="btn btn-icon  btn-sm btn-primary"><i class="far fa-edit"></i></a>
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