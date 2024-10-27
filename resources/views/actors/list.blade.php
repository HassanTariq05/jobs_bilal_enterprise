<x-layout-admin>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Actors</h4>
                            </div>
                            <div class="col-md-6 text-right">
                                <?php if (has_permission(26)) { ?>
                                    <a href="{{route('create-actor')}}" class="btn btn-sm btn-primary">Add New</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-sm" id="table-1">
                                <thead>
                                    <tr>
                                        <!--<th width="100" class="text-center">#</th>-->
                                        <th>ID</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Bio</th>
                                        <th class = "text-center">Actions</th>
                                        <!--<th>Updated At</th> -->
                                        </tr>
                                </thead>
                                <tbody>
                                    @if($rows->count())
                                    @foreach($rows as $row)
                                    <tr>
                                        <!--<td class="text-center">{{$loop->iteration}}</td> -->
                                        <td>{{$row->id}}</td>
                                        <td>{{$row->first_name}}</td>
                                        <td>{{$row->last_name}}</td>
                                        <td>{{$row->bio}}</td>
                                       <!-- <td class="text-center">
                                        <a href='{{ Route::has("edit-actor") ? route("edit-actor", [$row->id]) : "#"}}' data-toggle="tooltip" data-placement="left" title="" data-original-title="Edit Record" class='btn btn-icon  btn-sm btn-primary'>
                                            <i class="far fa-edit"></i>
                                        </a>
                                        
                                        <a href='{{ Route::has("trash-actor") ? route("trash-actor", [$row->id]) : "#"}}' data-toggle="tooltip" data-placement="left" title="" data-original-title="Delete Record" class='btn btn-icon  btn-sm btn-danger'>
                                            <i class="far fa-trash"></i>
                                        </a>
                                        </td> -->
                                        <!-- <td>{{$row->created_at}}</td>
                                        <td>{{$row->updated_at}}</td> -->
                                         <td class="text-center">
                                            <x-action-btn route="actors" id="{{$row->id}}" privilegeEditId="69" privilegeDeleteId="70" privilegeRestoreId="{{$row->deleted_at ? 71 : 0}}"  />
                                            <?php /*
                                            <a href="{{route('edit-bank', [$row->id])}}" class="btn btn-icon  btn-sm btn-primary"><i class="far fa-edit"></i></a>
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