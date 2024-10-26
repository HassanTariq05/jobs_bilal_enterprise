<x-layout-admin>


    <div id="job_main_div" class="row">
        <div class="col-12">
            <nav>
                <div class="nav nav-tabs  nav-justified" id="nav-tab" role="tablist">
                    <button class="nav-link active m-1" id="nav-privileges-tab" data-toggle="tab" data-target="#nav-privileges" type="button" role="tab" aria-controls="nav-privileges" aria-selected="true">
                        Privileges
                    </button>
                    <button class="nav-link m-1" id="nav-privilege_groups-tab" data-toggle="tab" data-target="#nav-privilege_groups" type="button" role="tab" aria-controls="nav-privilege_groups" aria-selected="false">
                        Privilege Groups
                    </button>
                    <button class="nav-link m-1" id="nav-privilege_categories-tab" data-toggle="tab" data-target="#nav-privilege_categories" type="button" role="tab" aria-controls="nav-privilege_categories" aria-selected="false">
                        Privilege Categories
                    </button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-privileges" role="tabpanel" aria-labelledby="nav-privileges-tab">

                    <div class="card">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Privileges</h4>
                                </div>
                                <div class="col-md-6 text-right">
                                    <a href="{{route('generate-privilege-json')}}" class="btn btn-sm btn-primary">jSon</a>
                                    <a href="{{route('create-privilege')}}" class="btn btn-sm btn-primary">Add New</a>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover table-striped table-sm data-table" id="table-1">
                                    <thead>
                                        <tr>
                                            <th width="100" class="text-center">#</th>
                                            <th>Category</th>
                                            <th>Group</th>
                                            <th>ID</th>
                                            <th>Title</th>
                                            <th>Title Short</th>
                                            <th class="text-center">Order By</th>
                                            <th width="100" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($privileges->count())
                                        @foreach($privileges as $row)
                                        <tr>
                                            <td class="text-center">{{$loop->iteration}}</td>
                                            <td>{{$row->privilege_group->privilege_category->title ?? ''}}</td>
                                            <td>{{$row->privilege_group->title ?? ''}}</td>
                                            <td>{{$row->id}}</td>
                                            <td>{{$row->title}}</td>
                                            <td>{{$row->short_title}}</td>
                                            <td class="text-center">{{$row->order_by}}</td>
                                            <td class="text-center">
                                                <a href="{{route('edit-privilege', [$row->id])}}" class="btn btn-icon  btn-sm btn-primary"><i class="far fa-edit"></i></a>
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
                <div class="tab-pane fade" id="nav-privilege_groups" role="tabpanel" aria-labelledby="nav-privilege_groups-tab">

                    <div class="card">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Privileges Groups</h4>
                                </div>
                                <div class="col-md-6 text-right">
                                    <a href="{{route('create-privilege-group')}}" class="btn btn-sm btn-primary">Add New</a>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover table-striped table-sm  data-table" id="table-1">
                                    <thead>
                                        <tr>
                                            <th width="100" class="text-center">ID</th>
                                            <th>Category</th>
                                            <th>Title</th>
                                            <th class="text-center">Order By</th>
                                            <th width="100" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($privilege_groups->count())
                                        @foreach($privilege_groups as $row)
                                        <tr>
                                            <td class="text-center">{{$row->id}}</td>
                                            <td>{{$row->privilege_category->title}}</td>
                                            <td>{{$row->title}}</td>
                                            <td class="text-center">{{$row->order_by}}</td>
                                            <td class="text-center">
                                                <a href="{{route('edit-privilege-group', [$row->id])}}" class="btn btn-icon  btn-sm btn-primary"><i class="far fa-edit"></i></a>
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
                <div class="tab-pane fade" id="nav-privilege_categories" role="tabpanel" aria-labelledby="nav-privilege_categories-tab">

                    <div class="card">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Privileges Categories</h4>
                                </div>
                                <div class="col-md-6 text-right">
                                    <a href="{{route('create-privilege-category')}}" class="btn btn-sm btn-primary">Add New</a>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover table-striped table-sm  data-table" id="table-1">
                                    <thead>
                                        <tr>
                                            <th width="100" class="text-center">ID</th>
                                            <th>Title</th>
                                            <th class="text-center">Order By</th>
                                            <th width="100" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($privilege_category->count())
                                        @foreach($privilege_category as $row)
                                        <tr>
                                            <td class="text-center">{{$row->id}}</td>
                                            <td>{{$row->title}}</td>
                                            <td class="text-center">{{$row->order_by}}</td>
                                            <td class="text-center">
                                                <a href="{{route('edit-privilege-category', [$row->id])}}" class="btn btn-icon  btn-sm btn-primary"><i class="far fa-edit"></i></a>
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
        </div>
    </div>

</x-layout-admin>