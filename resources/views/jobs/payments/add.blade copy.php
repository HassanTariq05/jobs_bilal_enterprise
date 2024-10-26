<x-layout-admin>
    <div class="row">
        <div class="col-12">
            <form method="post" action="">
                @csrf
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
                                        @if($vendors)
                                        @foreach($vendors as $row)
                                        <option value="{{$row->id}}">{{$row->title}}</option>
                                        @endforeach
                                        @endif
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



    <form id="paymentForm" method="post" action="{{route('store-job-payment')}}">
        @csrf
        <div id="payment_details" class="row hide">

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
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">Remove</th>
                                    <th>Bill #</th>
                                    <th>Job #</th>
                                    <th>Head</th>
                                    <th>Vendor Name</th>
                                    <th class="text-right">Balance</th>
                                    <th class="text-right">Amount</th>
                                </tr>
                            </thead>
                            <tbody id="bills_container">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <br />
            <br />

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header border-bottom bg-danger text-white text-center py-1 h6">
                        With Holding Tax
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="sales_tax_amount">Sales Tax With Held</label>
                                    <input id="sales_tax_amount" onkeyup="generateSummary();" type="text" class="form-control" name="sales_tax_amount" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="income_tax_amount">Income Tax With Held</label>
                                    <input id="income_tax_amount" onkeyup="generateSummary();" type="text" class="form-control" name="income_tax_amount" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <x-combobox of="sales_tax_territories" label="Sales Tax Territory" ref="sales_tax_territory_id" inline=0 />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br />
            <br />

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header border-bottom bg-success text-dark text-center py-1 h6">
                    Adjustment
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Head</label>
                                <select class="form-control select2" name="account_title_id" id="account_title_id">
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="adjustment_amount">Amount</label>
                                    <input id="adjustment_amount" onkeyup="generateSummary();" type="text" class="form-control" name="adjustment_amount" />
                                </div>
                            </div>
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
                                <x-combobox of="banks" label="Bank" ref="bank_id" inline=0 />
                                <div class="text-danger bi-error"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="instrument_amount">Instrument Amount</label>
                                    <input id="instrument_amount" onkeyup="generateSummary();" type="text" class="form-control" name="instrument_amount" />
                                    <div class="text-danger ia-error"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="instrument_no">Instrument #</label>
                                    <input id="instrument_no" type="text" class="form-control" name="instrument_no" />
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
                                    <label for="received_from">Received From</label>
                                    <input id="received_from" type="text" class="form-control" name="received_from" />
                                </div>
                            </div>
                            <x-combobox of="bank_accounts" label="Bank Account" ref="bank_account_id" inline=0 />
                            <div class="col-md-4">
                                <x-combobox of="payment_modes" label="Payment Mode" ref="payment_mode_id" inline=0 />
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
                        payment Summary
                    </div>
                    <div class="card-body">
                        <div id="payment_summary">
                            <table class="table table-sm">
                                <tr>
                                    <th>Bills Paid Amount</th>
                                    <td style="width: 200px;"></td>
                                    <td style="width: 200px;" id="bills_total" class="text-right"></td>
                                </tr>
                                <tr>
                                    <th><span class="pl-5">Tax Amount</span></th>
                                    <td id="tax_total" class="text-right"></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><span class="pl-5">Adjustment</span></th>
                                    <td id="adjustment_total" class="text-right"></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><span class="pl-5">Instrument</span></th>
                                    <td style="border-bottom:1px solid #efefef;" id="instrument_total" class="text-right"></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>Tax + Adjustment + Instrument</th>
                                    <td></td>
                                    <td id="comparative_total" class="text-right"></td>
                                </tr>
                                <tr>
                                    <th class="text-danger text-center">Difference</th>
                                    <td></td>
                                    <td style="border-top:1px solid #000; border-bottom:4px double #000;" id="difference_total" class="text-right"></td>
                                </tr>
                            </table>

                        </div>
                    </div>
                    <div class="card-footer text-right border-top">
                        <div class="row">
                            <div id="note" class="col-md-8">

                            </div>
                            <div class="col-md-4">
                                <button type="button" onclick="validatePaymentForm();" class="btn btn-primary">Submit</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </form>



    @section('exfooter')

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
                var balance = $(this).data("balance");
                var randn = Math.floor(Math.random() * 10000) + 1;
                _html += `
                            <tr id="bill_row_${randn}">
                                <td class="text-center">
                                    <i onclick="removeSelectedBill(${randn});" class="fa fa-times text-danger"></i>
                                    <input type="hidden" name="bill_id[]" value="${bill_id}" />
                                </td>
                                <td>${bill_no}</td>
                                <td>${job_no}</td>
                                <td>${location}</td>
                                <td>${party}</td>
                                <td class="text-right">${balance}</td>
                                <td><input  name="paid_amount[]" type="number" onkeyup="generateSummary();" class="form-control bill_paid_amount" /></td>
                            </tr>
                            `;
            });

            if (_html !== '') {
                $("#bills_container").append(_html);
                $("#payment_details").removeClass('hide');
                $("#billsList").modal('hide');
            }

        }

        function generateSummary() {
            var bills_total = 0;

            var tax = 0;
            var adjustment_amount = 0;
            var instrument_amount = 0;
            var other_total = 0;
            var difference_total = 0;

            $('.bill_paid_amount').each(function() {
                if ($(this).val() != '') {
                    bills_total += +$(this).val();
                }
            });

            if ($("#sales_tax_amount").val() != '') {
                tax += parseFloat($("#sales_tax_amount").val());
            }
            if ($("#income_tax_amount").val() != '') {
                tax += parseFloat($("#income_tax_amount").val());
            }
            if ($("#adjustment_amount").val() != '') {
                adjustment_amount = parseFloat($("#adjustment_amount").val());
            }
            if ($("#instrument_amount").val() != '') {
                instrument_amount = parseFloat($("#instrument_amount").val());
            }

            other_total = (tax + adjustment_amount + instrument_amount);

            difference_total = bills_total - other_total;

            $("#bills_total").html(bills_total);
            $("#tax_total").html(tax);
            $("#adjustment_total").html(adjustment_amount);
            $("#instrument_total").html(instrument_amount);
            $("#difference_total").html(difference_total);
            $("#comparative_total").html(other_total);

            if (difference_total != 0) {
                $("#note").html("<div class='alert alert-danger'>Please cover the difference amount before submit this payment.</div>");
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
            var instrument_amount = $("#instrument_amount").val();
            var instrument_no = $("#instrument_no").val();
            var bills_total = parseFloat($("#bills_total").html());

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

            if (instrument_no == '') {
                $('.in-error').html('required');
                is_error += 1;
            } else {
                $('.in-error').html('');
            }

            if (bills_total < 1) {
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



    @endsection



</x-layout-admin>