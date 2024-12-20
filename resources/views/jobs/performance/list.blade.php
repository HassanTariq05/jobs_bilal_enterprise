    <x-layout-admin>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Job Performance Excel Sheets</h4>
                            </div>
                            <div class="col-md-6 text-right">
                                <a href="{{route('edit-job', [Request::segment(3)])}}" class="btn btn-sm btn-dark">View Job</a>
                                <a href="{{route('create-job-performance', [Request::segment(3)])}}" class="btn btn-sm btn-primary">Add New</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-sm data-table" id="table-1">
                                <thead>
                                    <tr>
                                        <th width="100" class="text-center">#</th>
                                        <th>Uploaded Type</th>
                                        <th>Uploaded By</th>
                                        <th>Uploaded On</th>
                                        <th>File Name</th>
                                        <th width="100" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($rows->count())
                                    @foreach($rows as $row)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$row->performance_type}}</td>
                                        <td>{{$row->user->name}}</td>
                                        <td>{{$row->created_at}}</td>
                                        <td>{{$row->file_temp_name}}</td>
                                        <td class="text-center">
                                            <a href="{{route('show-job-performance', [request()->segment(3) ,$row->id])}}" data-toggle="tooltip" data-placement="left" title="" data-original-title="View Sheet Data" class='btn btn-icon  btn-sm btn-primary'>
                                                <i class="far fa-eye"></i>
                                            </a>
                                            <?php /*
                                            <a class='btn btn-icon btn-sm btn-danger text-white' data-toggle="tooltip" data-placement="left" title="" data-original-title="Delete Record">
                                                <i class="fas fa-times"></i>
                                            </a>
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
