<x-layout-admin>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Payments</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            <?php if (has_permission(50)) { ?>
                                <a href="{{route('create-job-payment')}}" class="btn btn-sm btn-primary">Add New</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-sm" id="table-1">
                            <thead>
                                <tr>
                                    <th width="100" class="text-center">ID</th>
                                    <th>Payment #</th>
                                    <th>Instrument #</th>
                                    <th>Amount</th>
                                    <th>Instrument Date</th>
                                    <th>Bills</th>
                                    <th width="100" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @if($rows)
                                    @foreach($rows as $row)
                                <tr>
                                    <td class="text-center">{{$row->id}}</td>
                                    <td>{{$row->payment_no}}</td>
                                    <td>{{$row->instrument_number}}</td>
                                    <td>{{$row->instrument_amount}}</td>
                                    <td>{{$row->instrument_date}}</td>
                                    <td>
                                        <?php
                                        if ($row->bills_numbers()) {
                                            echo implode(', ', $row->bills_numbers());
                                        } else {
                                            echo '-';
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <x-action-btn route="job-payment" id="{{$row->id}}" privilegeEditId="51" privilegeDeleteId="52" privilegeRestoreId="{{$row->deleted_at ? 53 : 0}}"  />
                                        <?php /*
                                        <a href="{{route('edit-job-payment', [$row->id])}}" class="btn btn-icon  btn-sm btn-primary"><i class="far fa-edit"></i></a>
                                        <a href="#" class="btn btn-icon  btn-sm btn-danger"><i class="fas fa-times"></i></a>
                                        */ ?>
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout-admin>