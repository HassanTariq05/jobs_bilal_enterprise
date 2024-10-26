    <x-layout-admin>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Journal Voucher</h4>
                            </div>
                            <div class="col-md-6 text-right">
                                <?php // if (has_permission(156)) { 
                                ?>
                                <a href="{{route('create-journal-voucher')}}" class="btn btn-sm btn-primary">Add New</a>
                                <?php // } 
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <?php
                        //echo "<pre>"; print_r($rows);
                        ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-sm data-table" id="table-1">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Voucher #</th>
                                        <th>Voucher Type</th>
                                        <th>Date</th>
                                        <th>Cheque No</th>
                                        <th>Cheque Date</th>
                                        <th width="100" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($rows->count())
                                    @foreach($rows as $row)
                                    <tr>
                                        <td class="text-center">{{$loop->iteration}}</td>
                                        <td>{{$row->voucher_no}}</td>
                                        <td>{{$row->voucher_type->title}}</td>
                                        <td>{{$row->date}}</td>
                                        <td>{{$row->cheque_no}}</td>
                                        <td>{{$row->cheque_date}}</td>
                                        <td>
                                            <x-action-btn route="journal-voucher" id="{{$row->id}}" />
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