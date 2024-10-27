<x-layout-admin>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Tanks</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            <?php if (has_permission(210)) { ?>
                                <a href="{{route('create-tank')}}" class="btn btn-sm btn-primary">Add New</a>
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
                                    <th>Tank Name</th>
                                    <th>Location</th>
                                    <th>Volume</th>
                                    <th>Supervisor</th>
                                    <th>Remarks</th>
                                    <th width="100" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($rows->count())
                                @foreach($rows as $row)
                                <tr>
                                    <td class="text-center">{{$loop->iteration}}</td>
                                    <td>{{$row->title}}</td>
                                    <td>{{$row->location}}</td>
                                    <td>{{$row->capacity}} ltr.</td>
                                    <td>{{$row->user->name ?? ''}}</td>
                                    <td>{!!$row->remarks!!}</td>
                                    <td class="text-center">
                                        <x-action-btn route="tank" id="{{$row->id}}" privilegeEditId="211" privilegeDeleteId="212"  privilegeRestoreId="{{$row->deleted_at ? 213 : 0}}" />
                                        <?php /*
                                        <a href="{{route('edit-tank', [$row->id])}}" class="btn btn-icon  btn-sm btn-primary"><i class="far fa-edit"></i></a>
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