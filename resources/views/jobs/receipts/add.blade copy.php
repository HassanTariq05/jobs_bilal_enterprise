<x-layout-admin>
    <div class="row">
        <div class="col-12">
            <form method="post" action="">
                @csrf
                <input type="hidden" id="client_id" value="" />
                <div class="card">
                    <div class="card-header border-bottom">
                        <h4>Search For Invoices:</h4>
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
                                    <label for="client_by_id">Client ID</label>
                                    <input id="client_by_id" onkeyup="showClientName(this.value);" type="number" class="form-control" name="client_by_id" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="client_by_name">Client</label>
                                    <select onchange="showClientId(this.value);" class="form-control select2" id="client_by_name" name="client_by_name">
                                        <option value="">--select--</option>
                                        @if($clients)
                                        @foreach($clients as $row)
                                        <option value="{{$row->id}}">{{$row->title}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 text-right">
                                <button type="button" onclick="getOutstandingInvoices();" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>



    <form id="receiptForm" method="post" action="{{route('store-job-receipt')}}">
        @csrf
        <div id="receipt_details" class="row hide">
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
                    <div class="card-header border-bottom bg-primary text-white text-center py-1">
                        <h4>Invoice Details</h4>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">Remove</th>
                                    <th>Invioce #</th>
                                    <th>Job #</th>
                                    <th>Head</th>
                                    <th>Client Name</th>
                                    <th class="text-right">Balance</th>
                                    <th class="text-right">Amount</th>
                                </tr>
                            </thead>
                            <tbody id="invoices_container">

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
                        Receipt Summary
                    </div>
                    <div class="card-body">
                        <div id="receipt_summary">
                            <table class="table table-sm">
                                <tr>
                                    <th>Invoices Received Amount</th>
                                    <td style="width: 200px;"></td>
                                    <td style="width: 200px;" id="invoices_total" class="text-right"></td>
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
                                <button type="button" onclick="validateReceiptForm();" class="btn btn-primary">Submit</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </form>



    @section('exfooter')

    <div class="modal fade" tabindex="-1" role="dialog" id="invoicesList">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select Outstanding Invoices</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th class="text-center">select</th>
                                <th>Invioce #</th>
                                <th>Job #</th>
                                <th>Location</th>
                                <th>Client Name</th>
                                <th class="text-right">Balance</th>
                            </tr>
                        </thead>
                        <tbody id="invoices_container_modal">
                            <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="button" onclick="selectInvoices();" class="btn btn-success">Select</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function getOutstandingInvoices() {
            $("#invoices_container_modal").html('');
            var job_no = $("#job_no").val();
            var document_date = $("#document_date").val();
            var client_id = $("#client_id").val();

            var params = {
                '_token': $('meta[name=csrf-token]').attr('content'),
                job_no: job_no,
                document_date: document_date,
                client_id: client_id
            };
            $("#invoicesList").modal('show');
            $.post('/jobs/receipts/getOutstandingInvoices', params, function(response) {
                //$("#receipt_details").removeClass('hide');
                $("#invoices_container_modal").html(response);


            });
        }



        function selectInvoices() {
            var _html = '';
            $('.invoices_chk_box:checkbox:checked').each(function() {
                var invoice_id = $(this).data("invoice_id");
                var invoice_no = $(this).data("invoice_no");
                var job_no = $(this).data("job_no");
                var location = $(this).data("location");
                var party = $(this).data("party");
                var balance = $(this).data("balance");
                var randn = Math.floor(Math.random() * 10000) + 1;
                _html += `
                            <tr id="inv_row_${randn}">
                                <td class="text-center">
                                    <i onclick="removeSelectedInvoice(${randn});" class="fa fa-times text-danger"></i>
                                    <input type="hidden" name="invoice_id[]" value="${invoice_id}" />
                                </td>
                                <td>${invoice_no}</td>
                                <td>${job_no}</td>
                                <td>${location}</td>
                                <td>${party}</td>
                                <td class="text-right">${balance}</td>
                                <td><input  name="received_amount[]" type="number" onkeyup="generateSummary();" class="form-control invoice_received_amount" /></td>
                            </tr>
                            `;
            });

            if (_html !== '') {
                $("#invoices_container").append(_html);
                $("#receipt_details").removeClass('hide');
                $("#invoicesList").modal('hide');
            }

        }

        function generateSummary() {
            var invoices_total = 0;

            var tax = 0;
            var adjustment_amount = 0;
            var instrument_amount = 0;
            var other_total = 0;
            var difference_total = 0;

            $('.invoice_received_amount').each(function() {
                if ($(this).val() != '') {
                    invoices_total += +$(this).val();
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

            difference_total = invoices_total - other_total;

            $("#invoices_total").html(invoices_total);
            $("#tax_total").html(tax);
            $("#adjustment_total").html(adjustment_amount);
            $("#instrument_total").html(instrument_amount);
            $("#difference_total").html(difference_total);
            $("#comparative_total").html(other_total);

            if (difference_total != 0) {
                $("#note").html("<div class='alert alert-danger'>Please cover the difference amount before submit this receipt.</div>");
            } else {
                $("#note").html("");
            }
        }

        function removeSelectedInvoice(ref) {
            $("#inv_row_" + ref).remove();
            generateSummary();
        }

        function validateReceiptForm() {
            var bank_id = $("#bank_id").val();
            var instrument_amount = $("#instrument_amount").val();
            var instrument_no = $("#instrument_no").val();
            var invoices_total = parseFloat($("#invoices_total").html());

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

            if (invoices_total < 1) {
                alert("You must select invoices to proceed.");
                is_error += 1;
                return false;
            }

            if (is_error > 0) {
                alert('Please cross check your form to proceed next.');
                return false;
            } else {
                $("#receiptForm").submit();
            }
        }
    </script>



    @endsection



</x-layout-admin>