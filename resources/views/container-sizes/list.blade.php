<x-layout-admin>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Container Sizes</h4>
                            </div>
                            <div class="col-md-6 text-right">
                                <?php if (has_permission(156)) { ?>
                                    <a href="{{route('create-container-size')}}" class="btn btn-sm btn-primary">Add New</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-sm data-table" id="table-1">
                                <thead>
                                    <tr>
                                        <th width="100" class="text-center">ID</th>
                                        <th width="150">Container Size</th>
                                        <th width="100" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($rows)
                                    @foreach($rows as $row)
                                    <tr>
                                        <td class="text-center">{{$row->id}}</td>
                                        <td>{{$row->container_size}}</td>
                                        <td class="text-center">
                                            <x-action-btn route="container-size" id="{{$row->id}}" privilegeEditId="69" privilegeDeleteId="70"/>
                                            <?php /*
                                            <a href="{{route('edit-location', [$row->id])}}" class="btn btn-icon  btn-sm btn-primary"><i class="far fa-edit"></i></a>
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