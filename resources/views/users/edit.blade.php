<x-layout-admin>

    <div class="row">
        <div class="col-12">
            <form method="post" action="{{route('update-user', [$row->id])}}" enctype='multipart/form-data'>
                @csrf
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Edit</h4>
                            </div>
                            <div class="col-md-6 text-right">
                                <?php if (has_permission(127)) { ?>
                                    <a href="{{route('users')}}" class="btn btn-sm btn-primary">View All</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Name</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" id="name" name="name" value="{{$row->name}}" class="form-control" />
                                @error('name')
                                <div class="text-danger">required</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Email</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="email" id="email" name="email" value="{{$row->email}}" class="form-control" />
                                @error('email')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <x-combobox of="designations" label="Designation" ref="designation_id" selected="{{$row->designation_id}}" />

                        <x-combobox of="user_roles" label="User Role" ref="user_role_id" selected="{{$row->user_role_id}}" />

                        <x-combo-users inline=1 ref="report_to" label="Report to" escape="{{$row->id}}" selected="{{$row->report_to}}" />

                        <div class="form-group row my-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                                <span class="badge badge-light px-2" data-toggle="tooltip" data-placement="right" title="" data-original-title="Left it blank if you do not want to change the password"><i class="fas fa-question"></i></span>
                                Password
                            </label>
                            <div class="col-sm-12 col-md-7">
                                <input type="password" id="password" name="password" value="" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Confirm Password</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="password" id="confirm_password" name="confirm_password" value="" class="form-control" />
                                @error('password')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Thumbnail</label>
                            <div class="col-sm-12 col-md-7">
                                <?php
                                $style = '';
                                if ($row->image) {
                                    $style = 'style="background-image:url(' . getFromStorage($row->image) . ')"';
                                }
                                ?>

                                <div id="image-preview" class="image-preview" <?= $style ?>>
                                    <label for="image-upload" id="image-label">Choose File</label>
                                    <input type="file" name="image" id="image-upload" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Remarks</label>
                            <div class="col-sm-12 col-md-7">
                                <textarea name="remarks" class="summernote-simple">{{$row->remarks}}</textarea>
                                @error('remarks')
                                <div class="text-danger">required</div>
                                @enderror
                            </div>
                        </div>

                        <x-combobox of="user_statuses" label="Status" ref="status_id" selected="{{$row->status_id}}" />

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-7">
                                <?php if (has_permission(129)) { ?>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</x-layout-admin>