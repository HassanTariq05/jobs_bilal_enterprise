<x-layout-admin>
    <div class="row">
        <div class="col-12">

            <form method="post" action="{{route('update-journal-voucher', [$row->id])}}" enctype="multipart/form-data">

                @csrf

                <div class="card">

                    <div class="card-header border-bottom">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Add New JV</h4>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="voucher_type_id">Voucher Type</label>
                                    <select class="form-control select2" onchange="updateFormFields(this.value);" id="voucher_type_id" name="voucher_type_id">
                                        <?php
                                        if ($voucher_types) {
                                            foreach ($voucher_types as $r) {
                                        ?>
                                                <option <?php if ($row->voucher_type_id == $r->id) ?> value="<?= $r->id; ?>"><?= $r->title; ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="date">Date</label>
                                    <input type="date" id="date" name="date" value="{{$row->date}}" class="form-control" />
                                    @error('date')
                                    <div class="text-danger">required</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <x-combobox of="companies" label="Company" ref="company_id" inline=0 selected="{{$row->company_id}}" />
                            </div>
                            <div class="col-md-3">
                                <x-combobox of="account_titles" label="Settlement Account" ref="account_title_id" inline=0 selected="{{$row->account_title_id}}" />
                            </div>
                            <div class="col-md-3">
                                <x-combobox of="locations" label="Cost Center" ref="location_id" inline=0 selected="{{$row->location_id}}" />
                            </div>
                            <div class="col-md-3 cheque-related">
                                <div class="form-group">
                                    <label for="cheque_no">Cheque #</label>
                                    <input type="text" id="cheque_no" name="cheque_no" value="{{$row->cheque_no}}" class="form-control" />
                                    @error('cheque_no')
                                    <div class="text-danger">required</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3 cheque-related">
                                <div class="form-group">
                                    <label for="cheque_date">Cheque Date</label>
                                    <input type="date" id="cheque_date" name="cheque_date" value="{{$row->cheque_date}}" class="form-control" />
                                    @error('cheque_date')
                                    <div class="text-danger">required</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="pay_to">Pay to</label>
                                    <input type="text" id="pay_to" name="pay_to" value="{{$row->pay_to}}" class="form-control" />
                                    @error('pay_to')
                                    <div class="text-danger">required</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-3">

                                <div class="form-group">
                                    <label for="form_cost_center">Cost Cente</label>
                                    <select class="form-control select2" id="form_cost_center">
                                        <?php
                                        if ($locations) {
                                            foreach ($locations as $r) {
                                        ?>
                                                <option value="<?= $r->id; ?>"><?= $r->title; ?></option>
                                        <?php
                                            }
                                        }
                                        ?>

                                    </select>
                                </div>

                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="form_settlement_account">Settlement Account</label>
                                    <select class="form-control select2" id="form_settlement_account">
                                        <?php
                                        if ($account_titles) {
                                            foreach ($account_titles as $r) {
                                        ?>
                                                <option value="<?= $r->id; ?>"><?= $r->title; ?></option>
                                        <?php
                                            }
                                        }
                                        ?>

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="form_dr_cr">Debit/Credit</label>
                                    <select class="form-control select2" id="form_dr_cr">
                                        <option value="dr">Debit</option>
                                        <option value="cr">Credit</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="form_amount">Amount</label>
                                    <input type="text" id="form_amount" class="form-control float" />
                                </div>
                            </div>
                            <div class="col-md-1 text-right">
                                <label>&nbsp;</label>
                                <input type="button" onclick="addRow();" class="btn btn-primary" value="Add" />
                            </div>

                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <table class="table table-sm table-stripped">
                            <thead class="border-bottom border-dark ">
                                <tr>
                                    <th class="text-center">Action</th>
                                    <th>Cost Center</th>
                                    <th>Settlement Account</th>
                                    <th class="text-center">Debit</th>
                                    <th class="text-center">Credit</th>
                                </tr>
                            </thead>
                            <tbody id="jv_items">
                                <?php
                                $debit_total = $credit_total = 0;
                                if ($row->items->count()) {
                                    foreach ($row->items as $item) {
                                        $debit_total+=$item->debit;
                                        $credit_total+=$item->credit;
                                ?>
                                        <tr class="" id="itme_<?= $item->id ?>">
                                            <td class="text-center">
                                                <i onclick="delete_jv_item(<?= $item->id ?>);" class="fa fa-times text-danger"></i>
                                            </td>
                                            <td>
                                                <?= get_specific_field_by_id('locations', 'title', $item->location_id) ?>
                                                <input type="hidden" name="item_location_id[]" value="<?= $item->location_id ?>" />
                                            </td>
                                            <td>
                                                <?= get_specific_field_by_id('account_titles', 'title', $item->account_title_id) ?>
                                                <input type="hidden" name="item_account_title_id[]" value="<?= $item->account_title_id ?>" />
                                            </td>
                                            <td class="w-200px">
                                                <input type="text" readonly name="item_debit[]" class="form-control w-200px text-right item_dr_amount py-1 h-100" value="<?= $item->debit ?>" />
                                            </td>
                                            <td class="w-200px">
                                                <input type="text" readonly name="item_credit[]" class="form-control w-200px text-right item_cr_amount py-1 h-100" value="<?= $item->credit ?>" />
                                            </td>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                            <tfoot class="border-top border-dark">
                                <tr>
                                    <th colspan="4" class="text-right">Debit</th>
                                    <th class="text-right w-200px">
                                        <input type="text" id="dr_total" readonly class="form-control w-200px text-right py-1 h-100" value="<?= $debit_total ?>" />
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="4" class="text-right">Credit</th>
                                    <th class="text-right w-200px">
                                        <input type="text" id="cr_total" readonly class="form-control w-200px text-right py-1 h-100" value="<?= $credit_total ?>" />
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="4" class="text-right">Net Amount</th>
                                    <th class="text-right w-200px border-top border-dark">
                                        <input type="text" id="net_amount" readonly class="form-control w-200px text-right py-1 h-100"  value="<?= ($debit_total-$credit_total) ?>" />
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body text-right">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>

            </form>
        </div>
    </div>


    @section('exfooter')

    <script>
        function updateFormFields(v) {
            if (v == 3 || v == 4 || v == 5) {
                $('.cheque-related').addClass('hide');
            } else {
                $('.cheque-related').removeClass('hide');
            }
        }

        function addRow() {

            var counter = get_random_number();
            var cost_center_id = $('#form_cost_center').val();
            var cost_center_title = $('#form_cost_center :selected').text();

            var settlement_account_id = $('#form_settlement_account').val();
            var settlement_account_title = $('#form_settlement_account :selected').text();

            var transaction_type = $('#form_dr_cr').val();
            var amount = $('#form_amount').val();

            if (cost_center_id == '') {
                alert("Please select cost center.");
                return false;
            }
            if (settlement_account_id == '') {
                alert("Please select settlement account.");
                return false;
            }
            if (transaction_type == '') {
                alert("Please select transaction type.");
                return false;
            }
            if (amount == '') {
                alert("Please enter amount.");
                return false;
            }

            var dr = cr = '';
            if (transaction_type == 'dr') {
                dr = amount;
            }
            if (transaction_type == 'cr') {
                cr = amount;
            }
            var html_row = `<tr class="" id="itme_${counter}">
                                <td class="text-center">
                                    <i onclick="delete_jv_item(${counter});" class="fa fa-times text-danger"></i>
                                </td>
                                <td>
                                    ${cost_center_title}
                                    <input type="hidden" name="item_location_id[]" value="${cost_center_id}" />
                                </td>
                                <td>
                                    ${settlement_account_title}
                                    <input type="hidden" name="item_account_title_id[]" value="${settlement_account_id}" />
                                </td>
                                <td class="w-200px">
                                    <input type="text" readonly name="item_debit[]" class="form-control w-200px text-right item_dr_amount py-1 h-100" value="${dr}" />
                                </td>
                                <td class="w-200px">
                                    <input type="text" readonly name="item_credit[]" class="form-control w-200px text-right item_cr_amount py-1 h-100" value="${cr}" />
                                </td>
                            </tr>`;
            $("#jv_items").append(html_row);
            reser_jv_itme_form();
            update_dr_cr();
        }

        function reser_jv_itme_form() {
            //$('#form_cost_center').val('');
            //$('#form_settlement_account').val('');
            //$('#form_dr_cr').val('');
            $('#form_amount').val('');
        }

        function delete_jv_item(ref) {
            $("#itme_" + ref).remove();
        }

        function update_dr_cr() {
            var dr_total = cr_total = net_amount = 0;
            $('.item_dr_amount').each(function() {
                if ($(this).val()) {
                    dr_total += parseInt($(this).val());
                }
            });
            $('.item_cr_amount').each(function() {
                if ($(this).val()) {
                    cr_total += parseInt($(this).val());
                }
            });

            $('#dr_total').val(dr_total);
            $('#cr_total').val(cr_total);
            var net = dr_total - cr_total;
            $('#net_amount').val(net);
        }
    </script>

    @endsection

</x-layout-admin>