    <x-layout-admin>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Parties</h4>
                            </div>
                            <div class="col-md-6 text-right">
                                <?php if (has_permission(198)) { ?>
                                    <a href="{{route('create-party')}}" class="btn btn-sm btn-primary">Add New</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">

                        <?php if (count($rows) > 0) { ?>

                            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                <?php
                                $c = 1;
                                foreach ($rows as $party_type) {
                                    if ($c < 2) {
                                        $class = 'active';
                                    } else {
                                        $class = '';
                                    }
                                ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?= $class ?>" id="<?= $party_type->slug ?>-tab2" data-toggle="tab" href="#<?= $party_type->slug ?>" role="tab" aria-controls="<?= $party_type->slug ?>" aria-selected="true">
                                            <?= $party_type->title ?>
                                        </a>
                                    </li>
                                <?php $c++;
                                }
                                ?>
                            </ul>
                            <div class="tab-content tab-bordered">

                                <?php
                                $c = 1;
                                foreach ($rows as $party_type) {
                                    if ($c < 2) {
                                        $class = 'active';
                                    } else {
                                        $class = '';
                                    }
                                ?>

                                    <div class="tab-pane fade show <?= $class ?>" id="<?= $party_type->slug ?>" role="tabpanel" aria-labelledby="<?= $party_type->slug ?>-tab2">
                                        <div class="h5"><?= $party_type->title ?> List</div>
                                        <div class="table-responsive">
                                            <table class="table table-hover table-striped table-sm data-table" id="table-1">
                                                <thead>
                                                    <tr>
                                                        <th width="100" class="text-center">#</th>
                                                        <th width="150">Short Name</th>
                                                        <th>Title</th>
                                                        <th>Address</th>
                                                        <th>Contact</th>
                                                        <th>Email</th>
                                                        <th>Contact Person</th>
                                                        <th>Bank Name</th>
                                                        <th>IBAN</th>
                                                        <th width="100" class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if($party_type->parties)
                                                    @foreach($party_type->parties as $row)
                                                    <tr>
                                                    <td class="text-center">{{$loop->iteration}}</td>
                                                        <td>{{$row->short_name}}</td>
                                                        <td>{{$row->title}}</td>
                                                        <td>{{$row->address}}</td>
                                                        <td>{{$row->contact}}</td>
                                                        <td>{{$row->email}}</td>
                                                        <td>{{$row->contact_person}}</td>
                                                        <td>{{$row->bank_name}}</td>
                                                        <td>{{$row->iban}}</td>
                                                        <td class="text-center">
                                                            <x-action-btn route="party" id="{{$row->id}}" privilegeEditId="199" privilegeDeleteId="200"  privilegeRestoreId="{{$row->deleted_at ? 201 : 0}}"   />
                                                            <?php /*
                                                            <a href="{{route('edit-party', [$row->id])}}" class="btn btn-icon  btn-sm btn-primary"><i class="far fa-edit"></i></a>
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

                                <?php $c++;
                                }
                                ?>


                            </div>




                        <?php } else { ?>
                            <div class="alert alert-danger">
                                Records not found.
                            </div>
                        <?php } ?>


                    </div>
                </div>
            </div>
        </div>
    </x-layout-admin>