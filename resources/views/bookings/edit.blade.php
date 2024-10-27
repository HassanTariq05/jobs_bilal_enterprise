<x-layout-admin>
    <div id="" class="row">
        <div class="col-12">
            <form method="post" action="{{route('update-job', 26)}}" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header border-bottom">


                        <div class="row">
                            <div class="col-md-6">
                                <h4>Edit : &nbsp;&nbsp;&nbsp;
                                    <span class="badge badge-secondary text-white"> Booking # {{$row[0]->bl_no}} </span>
                                </h4>
                            </div>
                            
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="row">
                        <div class="col-md-4">
                                <div class="form-group">
                                    <label for="booking">Booking</label>
                                    <input type="text" id="booking" name="booking" value="{{$row[0]->booking}}" class="form-control" required/>
                                    @error('booking')
                                    <div class="text-danger">required</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="bl_no">BL No</label>
                                    <input type="text" id="bl_no" name="bl_no" value="{{$row[0]->bl_no}}" class="form-control"  required/>
                                    @error('bl_no')
                                    <div class="text-danger">required</div>
                                    @enderror
                                </div>
                            </div>
                        <div class="col-md-4">
                                <x-combobox of="locations"  selected="{{$row[0]->loading_port}}" label="Loading Port" ref="loading_port" inline=0 />
                        </div>
                            
                        <div class="col-md-4">
                                <x-combobox of="locations"   selected="{{$row[0]->off_load}}"  label="Off Load" ref="off_load" inline=0 />
                        </div>
                        


                        <div class="col-md-4">
                                <x-combobox of="parties"   selected="{{$row[0]->customer}}"  label="Customer" ref="customer" inline=0 />
                        </div>
                            
                        <div class="col-md-4">
                                <x-combobox of="locations"  selected="{{$row[0]->location}}" label="Location" ref="location" inline=0 />
                        </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="document_date">Document Date</label>
                                    <input type="date" id="date" name="date" value="{{$row[0]->date}}" class="form-control"  required/>
                                    @error('document_date')
                                    <div class="text-danger">required</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="remarks">Remarks</label>
                                    <textarea class="form-control" id="remarks" name="remarks">{{$row[0]->remarks}}</textarea>
                                </div>
                            </div>
                           <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label" for="inputFile">Upload File:</label>
                                    <input type="file" name="files[]" id="files" class="form-control @error('files') is-invalid @enderror" accept=".xls,.xlsx,.pdf,.doc,.docx,.txt">
                                    @error('files')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <div>
                                        <label class="form-label" for="inputFile">Existing Files:</label>
                                    </div>
                                    <?php if ($file) { ?>
                                        <div class="row">
                                            <?php foreach ($file as $f) { ?>
                                                <div class="col-md-2 text-center">
                                                    <div class="text-right">
                                                        <a href="" class="fa fa-times text-danger delete-file"></a>
                                                    </div>
                                                    <div>
                                                        <a target="_blank" href="<?= getFromStorage($f->file_path); ?>">
                                                            <img src="<?= asset('assets/img/' . $f->ext . '.png'); ?>" />
                                                            
                                                        </a>
                                                    </div>
                                                    <div class="title text-center">
                                                        <?= $f->title ?>
                                                    </div>
                                                </div>

                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="remarks">Created on</label>
                                    <div>{{$row[0]->created_at}}</div>
                                </div>
                            </div> 
                        </div>
                    </div>
                    <div class="card-footer border-top">
                        <div class="row">
                            <div class="col-12 text-right">
                                <?php if (has_permission(68)) { ?>
                                    <button class="btn btn-primary" type = "submit">Submit</button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                    <!-- <div class="card-footer">
                        <div class="row">
                           <div class="col-md-12">

                                        <div class="text-right">
                                            <button class="btn btn-primary">Update</button>
                                        </div>
                                

                            </div>
                        
                        </div>
                    </div> --> 
                </div>
            </form>
          

   
    </div>
    <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Containers</h4>
                            </div>
                            
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-sm data-table" id="table-1">
                                <thead>
                                    <tr>
                                        <th width="100" class="text-center">#</th>
                                        <th>Booking</th>
                                        <th>BL No</th>
                                        <th>Container No</th>
                                        <th>Size</th>
                                        <th>Status</th>                                        
                                        <th>Vehicle No</th>
                                        <th>Trucking Mode</th>
                                        <th>Date</th>
                                        <th>Loading Port</th>
                                        <th>off Load</th>
                                        <!-- <th>Customer</th> -->
                                        <th>Remarks</th>
                                        <!-- <th width="100" class="text-center">Action</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                @if($containers)
                                    @foreach($containers as $container)
                                    <tr>
                                        <td class="text-center">{{$loop->iteration}}</td>
                                        <td>{{$container->booking}}</td>
                                        <td>{{$container->bl_no}}</td>
                                        
                                        <td>{{$container->container_no}}</td>
                                        <td>{{$container->size}}</td>
                                        <td>{{$container->status}}</td>
                                        <td>{{$container->vehicle_no}}</td>
                                        <td>{{$container->trucking_mode}}</td>
                                        <td>{{$container->date}}</td>


                                        <td>{{$container->loading_port}}</td>
                                        <td>{{$container->off_loading_port}}</td>
                                        <td>{{$container->remarks}}</td>
                                        
                                        
                                    </tr>
                                    @endforeach
                                    @endif                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    

   
    @section('exfooter')



    @endsection

</x-layout-admin>