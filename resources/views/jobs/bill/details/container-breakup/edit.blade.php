<x-layout-admin>

<?php //echo "<pre>"; print_r($rows); ?>

<div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Edit Bill Container Breakup Data</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            <a class="btn btn-dark" href="{{route('edit-job', [$job->id])}}">View Job</a>
                            <a class="btn btn-primary" href="{{route('create-job-bill-detail', [$job->id, $bill->id])}}">View Bill</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?php
                    if ($rows->count()) {
                        $bill_item_qty = 0;
                        $bill_item_rate = 0;
                        $bill_item_amount = 0;
                        $bill_item_tax_percentage = 0;
                        $bill_item_tax = 0;
                        $bill_item_net = 0;
                        $bill_item_des = [];
                        $counter = 0;
                    ?>
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-sm ">
                                        <thead>
                                            <tr>
                                                <th style="min-width:100px;">Head</th>
                                                <th style="min-width:100px;">Description</th>
                                                <th style="min-width:50px;text-align:right;">Rate</th>
                                                <th style="min-width:50px;text-align:center;">Qty</th>
                                                <th style="min-width:80px;text-align:right;">Amount Excluded Tax</th>
                                                <th style="min-width:100px;text-align:right;">Tax</th>
                                                <th style="min-width:120px;text-align:right;">Bill Amount</th>
                                                <th style="min-width:120px;text-align:center;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($rows as $row)
                                            <tr>
                                                <td>{{ $row->account_title->title }}</td>
                                                <td>
                                                    {{ $row->description }}
                                                </td>
                                                <td class="text-right">
                                                    {{ @amount($row->rate) }}
                                                </td>
                                                <td class="text-center">
                                                    {{ $row->qty }}
                                                    <?php $bill_item_qty += $row->qty ?>
                                                </td>
                                                <td class="text-right">
                                                    {{ @amount($row->amount) }}
                                                    <?php $bill_item_amount += $row->amount ?>
                                                </td>
                                                <td class="text-right">
                                                    {{ @amount($row->tax) }}
                                                    <?php
                                                    $bill_item_tax += $row->tax;
                                                    $bill_item_tax_percentage += $row->tax_percentage;
                                                    ?>
                                                </td>
                                                <td class="text-right">
                                                    {{ @amount($row->net) }}
                                                    <?php $bill_item_net += $row->net ?>
                                                </td>
                                                <td class="text-center">
                                                    <span onclick="hideIt('.breakup_details'); showIt('#details_<?= $row->id ?>');" data-toggle="tooltip" data-placement="left" title="" data-original-title="Show Details" class="btn btn-icon  btn-sm btn-primary">
                                                        <i class="far fa-eye"></i>
                                                    </span>

                                                    <span onclick="deleteContainerBreakup('<?= route('trash-job-bill-detail-container-breakup', [$row->id, $container_item_code]) ?>');" class="btn btn-icon btn-sm btn-danger" data-toggle="tooltip" data-placement="left" title="" data-original-title="Delete Record">
                                                        <i class="fas fa-trash"></i>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr id="details_<?= $row->id ?>" class="border m-3 hide breakup_details">
                                                <td colspan="8">
                                                    <div class="text-right p-2">
                                                        <span onclick="hideIt('.breakup_details');" class="btn btn-icon btn-sm btn-light" data-toggle="tooltip" data-placement="left" title="" data-original-title="Hide Details">
                                                            <i class="fa fa-times"></i>
                                                        </span>
                                                        <?php if ($row->items->count()) { ?>
                                                            <div class="table-responsive">
                                                                <table class="table table-sm bg-light data-table-no-paging">
                                                                    <thead>
                                                                        <tr class=" text-center">
                                                                            <th>BL #</th>
                                                                            <th>Container #</th>
                                                                            <th>Size</th>
                                                                            <th>Status</th>
                                                                            <th style="min-width:100px;">Vehicle #</th>
                                                                            <th style="min-width:150px;">Trucking Mode</th>
                                                                            <th style="min-width:100px;">Date</th>
                                                                            <th style="min-width:150px;">Loading Port</th>
                                                                            <th style="min-width:150px;">Off Loading Port</th>
                                                                            <th style="min-width:150px;">Party</th>
                                                                            <th style="min-width:150px;">Remarks</th>
                                                                            <th style="min-width:100px;">Rate</th>
                                                                            <th style="min-width:100px;">Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php $ids = 0;
                                                                        foreach ($row->items as $item) {
                                                                            $ids .= ',' . $item->id; ?>
                                                                            <tr class="text-center">
                                                                                <td><?= $item->bl_no ?></td>
                                                                                <td><?= $item->container_no ?></td>
                                                                                <td><?= $item->size ?></td>
                                                                                <td><?= $item->status ?></td>
                                                                                <td><?= $item->vehicle_no ?></td>
                                                                                <td><?= $item->trucking_mode ?></td>
                                                                                <td><?= $item->date ?></td>
                                                                                <td><?= $item->loading_port ?></td>
                                                                                <td><?= $item->off_loading_port ?></td>
                                                                                <td><?= $item->party ?></td>
                                                                                <td><?= $item->remarks ?></td>
                                                                                <td>
                                                                                    <?= amount($item->rate) ?>
                                                                                </td>
                                                                                <td>
                                                                                    <?php /*
                                                                                        <span data-toggle="tooltip" data-placement="left" title="" data-original-title="Update Rate" class="btn btn-icon  btn-sm btn-success">
                                                                                            <i class="fa fa-recycle"></i>
                                                                                        </span>
                                                                                        */ ?>
                                                                                    <span onclick="deleteContainerBreakup('<?= route('trash-job-bill-detail-container-breakup-item', [$item->id, $container_item_code]) ?>');" class="btn btn-icon btn-sm btn-danger" data-toggle="tooltip" data-placement="left" title="" data-original-title="Delete Record">
                                                                                        <i class="fas fa-trash"></i>
                                                                                    </span>
                                                                                </td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div class="text-left shadow-sm p-3">
                                                                <form method="post" action="{{route('update-bill-items-rate')}}">
                                                                    @csrf
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="shadow p-4 bg-secondary">
                                                                                <input type="hidden" name="ids" value="<?= $ids ?>" />
                                                                                <input type="hidden" name="cic" value="<?= $container_item_code ?>" />
                                                                                <input type="hidden" name="job_bill_container_breakup_id" value="<?= $row->id ?>" />
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <x-combobox of="sales_tax_territories" label="Sales Tax Territory" ref="sales_tax_territory_id" inline=0 selected="{{$row->sales_tax_territory_id}}" />
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <x-combobox of="account_titles" label="Head" ref="account_title_id" inline=0 selected="{{$row->account_title_id}}" />
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-4">
                                                                                        <div class="form-group">
                                                                                            <label for="rate<?= $row->id ?>">Rate</label>
                                                                                            <input id="rate<?= $row->id ?>" onchange="make_calculations(<?= $row->id ?>);sumup(<?= $row->id ?>);" onkeyup="make_calculations(<?= $row->id ?>);sumup(<?= $row->id ?>);" type="text" class="form-control" name="rate" value="{{$row->rate}}" />
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-4">
                                                                                        <div class="form-group">
                                                                                            <label for="qty<?= $row->id ?>">Qty</label>
                                                                                            <input id="qty<?= $row->id ?>" readonly type="number" class="form-control" name="qty" value="{{$row->qty}}" />
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-4">
                                                                                        <div class="form-group">
                                                                                            <label for="amount<?= $row->id ?>">Amount Excluding Tax</label>
                                                                                            <input id="amount<?= $row->id ?>" readonly type="text" class="form-control" name="amount" value="{{$row->amount}}" />
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <label for="tax">Tax</label>
                                                                                        <div class="input-group mb-2">
                                                                                            <input id="tax_percentage<?= $row->id ?>"  type="text" onkeyup="calculate_tax_amount(<?= $row->id ?>);sumup(<?= $row->id ?>);" class="form-control auto_select" name="tax_percentage"  value="{{$row->tax_percentage}}" placeholder="tax percentage" data-toggle="tooltip" data-placement="top" title="" data-original-title="Enter Tax in Percent" />
                                                                                            <div class="input-group-prepend">
                                                                                                <div class="input-group-text">%</div>
                                                                                            </div>
                                                                                            <input id="tax<?= $row->id ?>" type="text" onkeyup="calculate_tax_percentage(<?= $row->id ?>);sumup(<?= $row->id ?>);" class="form-control auto_select" name="tax" value="{{$row->tax}}" placeholder="tax amount" data-toggle="tooltip" data-placement="top" title="" data-original-title="Enter Tax in Amount" />
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label for="net<?= $row->id ?>">Bill Amount</label>
                                                                                            <input id="net<?= $row->id ?>" readonly type="text" class="form-control" name="net" value="{{$row->net}}" />
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <label for="description">Description</label>
                                                                                            <input id="description" type="text" class="form-control" name="description" value="{{$row->description}}" />
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <div class="mt-4_ text-right">
                                                                                            <button type="submit" class="btn btn-primary btn-block_ py-2">
                                                                                                Update
                                                                                            </button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        <?php } else { ?>
                                                            <div class="alert alert-danger">
                                                                Sorry! no items available.
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php $counter++; ?>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr class="border-top">
                                                <th colspan="2" class="text-center">TOTAL</th>
                                                <th class="text-right">
                                                    <?php $bill_item_rate = number_format((float)($bill_item_amount / $bill_item_qty), 2, '.', ''); ?>
                                                    {{($bill_item_rate)}}
                                                </th>

                                                <th class="text-center">{{$bill_item_qty}}</th>
                                                <th class="text-right">{{@amount($bill_item_amount)}}</th>
                                                <th class="text-right">{{@amount($bill_item_tax)}}</th>
                                                <th class="text-right">{{@amount($bill_item_net)}}</th>

                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="alert alert-danger">
                            Sorry! records not found.
                        </div>
                    <?php } ?>
                </div>
                <?php /* if ($rows->count()) { ?>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <button class="btn btn-primary"> Submit</button>
                                </div>
                            </div>
                        </div>
                    <?php } */ ?>
            </div>
        </div>
    </div>


    @section('exfooter')

    <div id="delete_confirmation_container_breakup" class="modal fade" tabindex="-1" role="dialog" id="list">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="container_breakup_item_delete_form" method="get" action="">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete Confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-2">Are you sure you want to delete this?</p>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger" type="submit">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        function deleteContainerBreakup(url) {
            $("#container_breakup_item_delete_form").attr('action', url);
            $('#delete_confirmation_container_breakup').modal('show');
        }
        /*
        function deleteContainerBreakupItem(url) {
            $("#container_breakup_item_delete_form").attr('action', url);
            $('#delete_confirmation_container_breakup_item').modal('show');
        }
        */







/*
        function getQtyTotal() {
            var counter = 0;
            $(".container_ids:checkbox:checked").each(function() {
                counter++;
            });

            $("#qty").val(counter);
            make_calculations();
        }
*/
        
        function sumup(ref) {
            var amount = 0;
            var tax = 0;
            if ($("#amount"+ref).val()) {
                amount = $("#amount"+ref).val();
            }
            if ($("#tax"+ref).val()) {
                tax = $("#tax"+ref).val();
            }
            var net = parseFloat(amount) + parseFloat(tax);
            $("#net"+ref).val(net);
        }

        function calculate_tax_amount(ref) {
            $("#tax_amount"+ref).val('');
            var amount = 0;
            var percent = $("#tax_percentage"+ref).val();
            if ($("#amount"+ref).val()) {
                amount = $("#amount"+ref).val();
            }
            if (percent != '') {
                $("#tax"+ref).val(((amount * percent) / 100));
            }
        }

        function calculate_tax_percentage(ref) {
            var amount = 0;
            var tax = $("#tax"+ref).val();
            if ($("#amount"+ref).val()) {
                amount = $("#amount"+ref).val();
            }
            if (tax != '') {
                $("#tax_percentage"+ref).val(((tax * 100) / amount).toFixed(2));
            }
        }


        function make_calculations(ref) {
            var qty = parseInt($("#qty"+ref).val());
            var rate = parseInt($("#rate"+ref).val());
            if (qty && rate) {
                var qty_rate_total = qty * rate;
                $("#amount"+ref).val(qty_rate_total);
            } else {
                $("#amount"+ref).val('')
            }
        }



    </script>


    @stop

</x-layout-admin>