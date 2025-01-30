<x-layout-admin>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Uploaded File Information</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="{{route('job-performance', [Request::segment(3)])}}" class="btn btn-sm btn-primary">View All</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                            Job #
                        </div>
                        <div class="col-sm-12 col-md-7">
                            <a target="_blank" href="{{route('edit-job', [$row->job->id])}}">
                                <?= $row->job->job_no; ?>
                            </a>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                            Uploaded By
                        </div>
                        <div class="col-sm-12 col-md-7">
                            <a target="_blank" href="{{route('edit-user', [$row->user->id])}}">
                                <?= $row->user->name; ?>
                            </a>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                            Uploaded On
                        </div>
                        <div class="col-sm-12 col-md-7">
                            <?= $row->created_at ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Excel Sheet Data</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?php if ($row->items->count()) { ?>
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-sm data-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <!-- <th class="text-center">Action</th> -->
                                            <th>Bill of Ladding no.</th>
                                            <th>Container no.</th>
                                            <th>Open Cargo</th>
                                            <th>Size</th>
                                            <th>Status</th>
                                            <th>Vehicle no.</th>
                                            <th>Trucking mode</th>
                                            <th>Date</th>
                                            <th>Loading Port</th>
                                            <th>Off Load</th>
                                            <th>Name</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($row->items as $r)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <!-- <td class="text-center">
                                                <input type="checkbox" aria-label="Checkbox for following text input">
                                            </td> -->
                                            <td>{{ $r->bl_no }}</td>
                                            <td>{{ $r->container_no }}</td>
                                            <td>{{ $r->container_no ? "YES" : "NO" }}</td>
                                            <td>{{ $r->size }}</td>
                                            <td>{{ $r->status }}</td>
                                            <td>{{ $r->vehicle_no }}</td>
                                            <td>{{ $r->trucking_mode }}</td>
                                            <td>{{ $r->date }}</td>
                                            <td>{{ $r->loading_port }}</td>
                                            <td>{{ $r->off_loading_port }}</td>
                                            <td>{{ $r->party }}</td>
                                            <td>{{ $r->remarks }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="alert alert-danger">
                            Sorry! records not found.
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>



</x-layout-admin>