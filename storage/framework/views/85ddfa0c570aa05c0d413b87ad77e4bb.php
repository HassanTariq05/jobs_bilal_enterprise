<?php if (isset($component)) { $__componentOriginald512d371ecbc414f6bdb34c51590ff29 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald512d371ecbc414f6bdb34c51590ff29 = $attributes; } ?>
<?php $component = App\View\Components\LayoutAdmin::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layout-admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\LayoutAdmin::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    <div class="row">
        <div class="col-12">
            <form method="post" action="">
                <?php echo csrf_field(); ?>
                <input type="hidden" id="vendor_id" value="" />
                <div class="card">
                    <div class="card-header border-bottom">
                        <h4>Search For BIlls:</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="job_no">Job no</label>
                                    <input id="job_no" type="text" class="form-control" name="job_no" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="document_date">Document Date</label>
                                    <input id="document_date" type="date" class="form-control" name="document_date" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="vendor_by_id">Vendor ID</label>
                                    <input id="vendor_by_id" onkeyup="showVendorName(this.value);" type="number" class="form-control" name="vendor_by_id" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="vendor_by_name">Vendor</label>
                                    <select onchange="showVendorId(this.value);" class="form-control select2" id="vendor_by_name" name="vendor_by_name">
                                        <option value="">--select--</option>
                                        <?php if($vendors): ?>
                                        <?php $__currentLoopData = $vendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($row->id); ?>"><?php echo e($row->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 text-right">
                                <button type="button" onclick="getOutstandingBills();" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>



    <form id="paymentForm" method="post" action="<?php echo e(route('store-job-payment')); ?>">
        <?php echo csrf_field(); ?>
        <div id="payment_details" class="row  <?php if (!$bill_info) {
                                                    echo  'hide';
                                                } ?>">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header border-bottom bg-primary text-white text-center py-1">
                        <h4>General Info</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="document_date">Document Date</label>
                                    <input id="document_date" type="date" class="form-control" name="document_date" />
                                    <div class="text-danger in-error"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <?php if (isset($component)) { $__componentOriginal40287e078f2da5df027b9b5ca93fb61e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40287e078f2da5df027b9b5ca93fb61e = $attributes; } ?>
<?php $component = App\View\Components\Combobox::resolve(['of' => 'sales_tax_territories','label' => 'Sales Tax Territory','ref' => 'sales_tax_territory_id','inline' => '0'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('combobox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Combobox::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40287e078f2da5df027b9b5ca93fb61e)): ?>
<?php $attributes = $__attributesOriginal40287e078f2da5df027b9b5ca93fb61e; ?>
<?php unset($__attributesOriginal40287e078f2da5df027b9b5ca93fb61e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40287e078f2da5df027b9b5ca93fb61e)): ?>
<?php $component = $__componentOriginal40287e078f2da5df027b9b5ca93fb61e; ?>
<?php unset($__componentOriginal40287e078f2da5df027b9b5ca93fb61e); ?>
<?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br />
            <br />

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header border-bottom bg-primary text-white text-center py-1">
                        <h4>Bill Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center"><i class="fa fa-trash"></i></th>
                                        <th style="width:140px;">Bill #</th>
                                        <th style="width:100px;">Job #</th>
                                        <th>Head</th>
                                        <th>Vendor Name</th>
                                        <th class="text-right">Balance</th>


                                        <th class="text-right">Sales Tax With Held</th>
                                        <th class="text-right">Income Tax With Held</th>
                                        <th class="text-center">Head</th>
                                        <th class="text-right">Adjustment</th>
                                        <th class="text-right">Amount</th>

                                        <th class="text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody id="bills_container">
                                    <?php if ($bill_info) { ?>
                                        <tr id="bill_row_<?= $bill_info->id ?>">
                                            <td class="text-center">
                                                <input type="hidden" name="bill_id[]" value="<?= $bill_info->id ?>" />
                                            </td>
                                            <td><?php echo e($bill_info->bill_no); ?></td>
                                            <td><?php echo e($bill_info->job->job_no); ?></td>
                                            <td><?php echo e($bill_info->job->location->title); ?></td>
                                            <td title="<?php echo e($bill_info->party->title); ?>"><?php echo e($bill_info->party->short_name); ?></td>
                                            <td class="text-right balance"><?php echo e($bill_info->job_bill_balance()); ?></td>

                                            <td><input style="width:100px" name="sales_tax_with_held[]" id="sales_tax_with_held" type="number" onkeyup="get_Row_total(<?= $bill_info->id ?>); generateSummary();" class="form-control float sales_tax_with_held sales_tax_with_held_<?= $bill_info->id ?>" /></td>
                                            <td><input style="width:100px" name="income_tax_with_held[]" id="income_tax_with_held" type="number" onkeyup="get_Row_total(<?= $bill_info->id ?>); generateSummary();" class="form-control float income_tax_with_held income_tax_with_held_<?= $bill_info->id ?>" /></td>
                                            <td>

                                                <select class="form-control _select2" name="account_title_id[]" style="width:100px;">
                                                    <option value="">--select--</option>
                                                    <?php
                                                    if ($heads) {
                                                        foreach ($heads as $head) {
                                                    ?>
                                                            <option value="<?= $head->id; ?>"><?= $head->title; ?></option>
                                                    <?php }
                                                    } ?>
                                                </select>

                                            </td>
                                            <td><input style="width:100px" name="adjustment_amount[]" id="adjustment_amount" type="number" onkeyup="get_Row_total(<?= $bill_info->id ?>); generateSummary();" class="form-control float adjustment_amount adjustment_amount_<?= $bill_info->id ?>" /></td>

                                            <td><input style="width:100px" name="paid_amount[]" type="number" onkeyup="get_Row_total(<?= $bill_info->id ?>); generateSummary();" class="form-control float bill_paid_amount bill_paid_amount_<?= $bill_info->id ?>" /></td>
                                            <td><input style="width:100px" name="bill_row_total[]" type="number" onchange="generateSummary();" class="form-control bill_row_total  float bill_row_total_<?= $bill_info->id ?>" /></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <br />
            <br />


            <div class="col-md-12">
                <div class="card">
                    <div class="card-header border-bottom bg-warning text-white text-center py-1 h6">
                        Instrument Details
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <?php if (isset($component)) { $__componentOriginal40287e078f2da5df027b9b5ca93fb61e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40287e078f2da5df027b9b5ca93fb61e = $attributes; } ?>
<?php $component = App\View\Components\Combobox::resolve(['of' => 'banks','label' => 'Bank','ref' => 'bank_id','inline' => '0'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('combobox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Combobox::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40287e078f2da5df027b9b5ca93fb61e)): ?>
<?php $attributes = $__attributesOriginal40287e078f2da5df027b9b5ca93fb61e; ?>
<?php unset($__attributesOriginal40287e078f2da5df027b9b5ca93fb61e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40287e078f2da5df027b9b5ca93fb61e)): ?>
<?php $component = $__componentOriginal40287e078f2da5df027b9b5ca93fb61e; ?>
<?php unset($__componentOriginal40287e078f2da5df027b9b5ca93fb61e); ?>
<?php endif; ?>
                                <div class="text-danger bi-error"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="instrument_amount">Instrument Amount</label>
                                    <input onkeyup="generateSummary();" type="text" id="instrument_amount_input" class="form-control float instrument_amount" name="instrument_amount" />
                                    <div class="text-danger ia-error"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="instrument_number">Instrument #</label>
                                    <input id="instrument_number" type="text" class="form-control" name="instrument_number" />
                                    <div class="text-danger in-error"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="instrument_date">Instrument Date</label>
                                    <input id="instrument_date" type="date" class="form-control" name="instrument_date" />
                                    <div class="text-danger in-error"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="paid_to">Paid to</label>
                                    <input id="paid_to" type="text" class="form-control" name="paid_to" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <?php if (isset($component)) { $__componentOriginal40287e078f2da5df027b9b5ca93fb61e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40287e078f2da5df027b9b5ca93fb61e = $attributes; } ?>
<?php $component = App\View\Components\Combobox::resolve(['of' => 'bank_accounts','label' => 'Bank Account','ref' => 'bank_account_id','inline' => '0'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('combobox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Combobox::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40287e078f2da5df027b9b5ca93fb61e)): ?>
<?php $attributes = $__attributesOriginal40287e078f2da5df027b9b5ca93fb61e; ?>
<?php unset($__attributesOriginal40287e078f2da5df027b9b5ca93fb61e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40287e078f2da5df027b9b5ca93fb61e)): ?>
<?php $component = $__componentOriginal40287e078f2da5df027b9b5ca93fb61e; ?>
<?php unset($__componentOriginal40287e078f2da5df027b9b5ca93fb61e); ?>
<?php endif; ?>
                            </div>
                            <div class="col-md-4">
                                <?php if (isset($component)) { $__componentOriginal40287e078f2da5df027b9b5ca93fb61e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40287e078f2da5df027b9b5ca93fb61e = $attributes; } ?>
<?php $component = App\View\Components\Combobox::resolve(['of' => 'payment_modes','label' => 'Payment Mode','ref' => 'payment_mode_id','inline' => '0'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('combobox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Combobox::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40287e078f2da5df027b9b5ca93fb61e)): ?>
<?php $attributes = $__attributesOriginal40287e078f2da5df027b9b5ca93fb61e; ?>
<?php unset($__attributesOriginal40287e078f2da5df027b9b5ca93fb61e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40287e078f2da5df027b9b5ca93fb61e)): ?>
<?php $component = $__componentOriginal40287e078f2da5df027b9b5ca93fb61e; ?>
<?php unset($__componentOriginal40287e078f2da5df027b9b5ca93fb61e); ?>
<?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br />
            <br />


            <div class="col-md-12">
                <div class="card">
                    <div class="card-header h5 border-bottom">
                        Summary
                    </div>
                    <div class="card-body">
                        <div id="receipt_summary">
                            <table class="table table-sm">
                                <tr>
                                    <th>Total Bill Amount</th>
                                    <td style="width: 200px;"></td>
                                    <td style="width: 200px;" id="bills_total" class="text-right "></td>
                                </tr>
                                <tr>
                                    <th>Amount Settled</th>
                                    <td style="width: 200px;"></td>
                                    <td style="width: 200px;" id="amount_settled" class="text-right"></td>
                                </tr>
                                <tr class="border-top border-bottom">
                                    <th class="text-center">Net outstanding balance</th>
                                    <td style="width: 200px;"></td>
                                    <td style="width: 200px;" id="outstanding_balance" class="text-right"></td>
                                </tr>
                                <tr>
                                    <th colspan="3"></th>
                                </tr>
                                <tr>
                                    <th colspan="3" class="h5">Reconciliation</th>
                                </tr>
                                <tr>
                                    <th>Instrument amount</th>
                                    <td style="width: 200px;"></td>
                                    <td style="width: 200px;" id="instrument_amount" class="text-right"></td>
                                </tr>
                                <tr>
                                    <th>Tax with held</th>
                                    <td style="width: 200px;"></td>
                                    <td style="width: 200px;" id="tax_with_held" class="text-right"></td>
                                </tr>
                                <tr>
                                    <th>Adjustment</th>
                                    <td style="width: 200px;"></td>
                                    <td style="width: 200px;" id="adjustment" class="text-right"></td>
                                </tr>
                                <tr class="border-top border-bottom">
                                    <th class="text-center">instrument amount + tax with held + adjustment</th>
                                    <td style="width: 200px;"></td>
                                    <td style="width: 200px;" id="inst_tax_adjustment" class="text-right"></td>
                                </tr>
                                <tr>
                                    <th colspan="3"></th>
                                </tr>
                                <tr>
                                    <th colspan="3"></th>
                                </tr>
                                <tr>
                                    <th colspan="3"></th>
                                </tr>
                                <tr>
                                    <th class="text-center">Difference</th>
                                    <td style="width: 200px;"></td>
                                    <td style="width: 200px;" id="difference" class="text-right"></td>
                                </tr>


                            </table>

                        </div>
                    </div>
                    <div class="card-footer text-right border-top">
                        <div class="row">
                            <div id="note" class="col-md-8">

                            </div>
                            <div class="col-md-4">
                                <?php if (has_permission(50)) { ?>
                                    <button type="button" onclick="validatePaymentForm();" class="btn btn-primary">Submit</button>
                                <?php } ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </form>



    <?php $__env->startSection('exfooter'); ?>

    <div class="col-md-4 hide" id="account_head_source">
        <select class="form-control _select2" name="account_title_id[]" style="width:100px;">
            <option value="">--select--</option>
            <?php
            if ($heads) {
                foreach ($heads as $head) {
            ?>
                    <option value="<?= $head->id; ?>"><?= $head->title; ?></option>
            <?php }
            } ?>
        </select>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="billsList">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select Outstanding Bills</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th class="text-center">select</th>
                                <th>Bill #</th>
                                <th>Job #</th>
                                <th>Location</th>
                                <th>Vendor Name</th>
                                <th class="text-right">Balance</th>
                            </tr>
                        </thead>
                        <tbody id="bills_container_modal">
                            <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="button" onclick="selectBills();" class="btn btn-success">Select</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function getOutstandingBills() {
            $("#bills_container_modal").html('');
            var job_no = $("#job_no").val();
            var document_date = $("#document_date").val();
            var vendor_id = $("#vendor_id").val();

            var params = {
                '_token': $('meta[name=csrf-token]').attr('content'),
                job_no: job_no,
                document_date: document_date,
                vendor_id: vendor_id
            };
            $("#billsList").modal('show');
            $.post('/jobs/payments/getOutstandingBills', params, function(response) {
                //$("#payment_details").removeClass('hide');
                $("#bills_container_modal").html(response);
            });
        }

        function showVendorName(ref) {
            $("#vendor_id").val(ref);
            $('#vendor_by_name').prop('selectedIndex', ref).selectric('refresh');
        }

        function showVendorId(ref) {
            $("#vendor_id").val(ref);
            $("#vendor_by_id").val(ref);
        }

        function selectBills() {
            var _html = '';
            $('.bills_chk_box:checkbox:checked').each(function() {
                var bill_id = $(this).data("bill_id");
                var bill_no = $(this).data("bill_no");
                var job_no = $(this).data("job_no");
                var location = $(this).data("location");
                var party = $(this).data("party");
                var party_short_name = $(this).data("party_short_name");
                var balance = $(this).data("balance");
                var randn = Math.floor(Math.random() * 10000) + 1;

                var head_dropdown = $("#account_head_source").html();

                _html += `
                            <tr id="bill_row_${randn}">
                                <td class="text-center">
                                    <i onclick="removeSelectedBill(${randn});" class="fa fa-times text-danger"></i>
                                    <input type="hidden" name="bill_id[]" value="${bill_id}" />
                                </td>
                                <td>${bill_no}</td>
                                <td>${job_no}</td>
                                <td>${location}</td>
                                <td title="${party}">${party_short_name}</td>
                                <td class="text-right balance">${balance}</td>

                                
                                <td><input style="width:100px"  name="sales_tax_with_held[]" id="sales_tax_with_held" type="number" onkeyup="get_Row_total(${bill_id}); generateSummary();" class="form-control sales_tax_with_held sales_tax_with_held_${bill_id}" /></td>
                                <td><input style="width:100px"  name="income_tax_with_held[]" id="income_tax_with_held" type="number" onkeyup="get_Row_total(${bill_id}); generateSummary();" class="form-control income_tax_with_held income_tax_with_held_${bill_id}" /></td>
                                <td>${head_dropdown}</td>
                                <td><input style="width:100px"  name="adjustment_amount[]" id="adjustment_amount" type="number" onkeyup="get_Row_total(${bill_id}); generateSummary();" class="form-control adjustment_amount adjustment_amount_${bill_id}" /></td>

                                <td><input style="width:100px"  name="paid_amount[]" type="number" onkeyup="get_Row_total(${bill_id}); generateSummary();" class="form-control bill_paid_amount bill_paid_amount_${bill_id}" /></td>
                                <td><input style="width:100px"  name="bill_row_total[]" type="number" onchange="generateSummary();" class="form-control bill_row_total  bill_row_total_${bill_id}" /></td>
                            </tr>
                            `;
            });

            if (_html !== '') {
                $("#bills_container").append(_html);
                $("#payment_details").removeClass('hide');
                $("#billsList").modal('hide');
            }

        }

        function get_Row_total(ref) {
            var total = 0;
            var sales_tax = parseInt($(".sales_tax_with_held_" + ref).val());
            var income_tax = parseInt($(".income_tax_with_held_" + ref).val());
            var adjustment = parseInt($(".adjustment_amount_" + ref).val());
            var bill_paid_amount = parseInt($(".bill_paid_amount_" + ref).val());

            //if(sales_tax!='' || sales_tax!='NaN'){
            if (sales_tax) {
                total += sales_tax;
            }
            //if(income_tax!='' || income_tax!='NaN'){
            if (income_tax) {
                total += income_tax;
            }
            //if(adjustment!='' || adjustment!='NaN'){
            if (adjustment) {
                total += adjustment;
            }
            //if(bill_paid_amount_!='' || bill_paid_amount_!='NaN'){
            if (bill_paid_amount) {
                total += bill_paid_amount;
            }

            $(".bill_row_total_" + ref).val(total);
        }

        function generateSummary() {

            var bills_total = 0;
            var amount_settled = 0;
            var outstanding_balance = 0;

            var instrument_amount = 0;
            var tax_with_held = 0;
            var adjustment = 0;
            //var instrument_amount_tax_with_held_adjustment = 0;
            var inst_tax_adjustment = 0;

            var difference = 0;

            $('.balance').each(function() {
                if ($(this).html() != '') {
                    bills_total += +$(this).html();
                }
            });
            $('.bill_row_total').each(function() {
                if ($(this).val() != '') {
                    amount_settled += +$(this).val();
                }
            });
            outstanding_balance = (parseInt(bills_total) - amount_settled);


            instrument_amount = $(".instrument_amount").val();
            $('.sales_tax_with_held').each(function() {
                if ($(this).val() != '') {
                    tax_with_held += +$(this).val();
                }
            });
            $('.income_tax_with_held').each(function() {
                if ($(this).val() != '') {
                    tax_with_held += +$(this).val();
                }
            });

            $('.adjustment_amount').each(function() {
                if ($(this).val() != '') {
                    adjustment += +$(this).val();
                }
            });
            inst_tax_adjustment = (parseInt(instrument_amount) + parseInt(tax_with_held) + parseInt(adjustment));


            $("#bills_total").html(bills_total);
            $("#amount_settled").html(amount_settled);
            $("#outstanding_balance").html(outstanding_balance);

            $("#instrument_amount").html(instrument_amount);
            $("#tax_with_held").html(tax_with_held);
            $("#adjustment").html(adjustment);

            $("#inst_tax_adjustment").html(inst_tax_adjustment);

            difference = (amount_settled - inst_tax_adjustment);

            $("#difference").html(difference);

            if (difference != 0) {
                $("#note").html("<div class='alert alert-danger'>Please cover the difference amount before submit this receipt.</div>");
            } else {
                $("#note").html("");
            }

        }

        function removeSelectedBill(ref) {
            $("#bill_row_" + ref).remove();
            generateSummary();
        }

        function validatePaymentForm() {
            var bank_id = $("#bank_id").val();
            var instrument_amount = $(".instrument_amount_input").val();
            var instrument_number = $("#instrument_number").val();
            var amount_settled = parseFloat($("#amount_settled").html());

            var is_error = 0;

            if (bank_id == '') {
                $('.bi-error').html('required');
                is_error += 1;
            } else {
                $('.bi-error').html('');
            }

            if (instrument_amount == '') {
                $('.ia-error').html('required');
                is_error += 1;
            } else {
                $('.ia-error').html('');
            }

            if (instrument_number == '') {
                $('.in-error').html('required');
                is_error += 1;
            } else {
                $('.in-error').html('');
            }

            if (amount_settled < 1) {
                alert("You must select bills to proceed.");
                is_error += 1;
                return false;
            }

            if (is_error > 0) {
                alert('Please cross check your form to proceed next.');
                return false;
            } else {
                $("#paymentForm").submit();
            }
        }
    </script>



    <?php $__env->stopSection(); ?>



 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald512d371ecbc414f6bdb34c51590ff29)): ?>
<?php $attributes = $__attributesOriginald512d371ecbc414f6bdb34c51590ff29; ?>
<?php unset($__attributesOriginald512d371ecbc414f6bdb34c51590ff29); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald512d371ecbc414f6bdb34c51590ff29)): ?>
<?php $component = $__componentOriginald512d371ecbc414f6bdb34c51590ff29; ?>
<?php unset($__componentOriginald512d371ecbc414f6bdb34c51590ff29); ?>
<?php endif; ?><?php /**PATH C:\Users\Owais\Downloads\BE\jobs\jobs\resources\views/jobs/payments/add.blade.php ENDPATH**/ ?>