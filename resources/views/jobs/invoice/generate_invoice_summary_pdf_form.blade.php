<x-layout-admin>

    <?php if ($submit) { ?>
        <?php
        $totals = $inv->job_invoice_totals();
        ?>
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <tr>
                        <td>
                            <table class="table">
                                <tr>
                                    <td style="width: 25%;">
                                        <img style="height:60px;" src="<?= asset($inv->job->company->logo) ?>" />
                                    </td>
                                    <td style="width: 50%;font-size:22px;" class="text-center font-weight-bold">
                                        SALES TAX INVOICE
                                    </td>
                                    <td style="width: 25%;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table class="table">
                                <tr>
                                    <td class="nop" style="vertical-align: top;">
                                        <table class="table table-invoice m-0">
                                            <tr>
                                                <td style="width: 80px;">Invoice No.</td>
                                                <td><?= $inv->inv_no ?></td>
                                            </tr>
                                            <tr>
                                                <td>Name</td>
                                                <td><?= $inv->party->title ?></td>
                                            </tr>
                                            <tr>
                                                <td>Address</td>
                                                <td><?= $inv->party->address ?></td>
                                            </tr>
                                            <tr>
                                                <td>NTN #</td>
                                                <td><?= $inv->party->ntn ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td class="nop" style="vertical-align: top;width:150px;">
                                        <table class="table table-invoice">
                                            <tr>
                                                <td style="width: 50px;">Date</td>
                                                <td><?= date_format($inv->created_at, "d-m-Y") ?></td>
                                            </tr>
                                            <tr>
                                                <td>NTN #</td>
                                                <td><?= $inv->job->company->ntn; ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class="">
                            <table class="table  table-invoice border">
                                <thead>
                                    <tr>
                                        <th class="border">Description</th>
                                        <th style="width:60px;" class="text-center border">Qty</th>
                                        <th style="width:100px;" class="text-right border">Rate</th>
                                        <th style="width:150px;" class="text-right border">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($inv->items as $i) { ?>
                                        <tr>
                                            <td>
                                                <strong><?= $i->account_title->title ?> </strong>: <?= $i->description ?>
                                            </td>
                                            <td class="text-center"><?= $i->qty ?></td>
                                            <td class="text-right"><?= amount($i->rate, 0) ?></td>
                                            <td class="text-right"><?= amount($i->amount, 0) ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot class="border">
                                    <tr>
                                        <td class="text-right" colspan="3">Value Excl. Sale Tax</td>
                                        <td class="text-right border"><?= amount($totals['amount'], 0) ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right" colspan="3">Sindh Sale Tax 15%</td>
                                        <td class="text-right border"><?= amount($totals['tax'], 0) ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right " colspan="3">Value Inclu. Sale Tax</td>
                                        <td class="text-right border"><?= amount($totals['net'], 0) ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table class="table table-invoice">
                                <tr>
                                    <th colspan="2" style="text-align: left;">Beneficiary Details:</th>
                                </tr>
                                <tr>
                                    <th style="text-align:left;width:100px;">Bank Name :</th>
                                    <td><?= $bank_account->bank  ?></td>
                                </tr>
                                <tr>
                                    <th style="text-align:left;">A/C Title :</th>
                                    <td><?= $bank_account->title  ?></td>
                                </tr>
                                <tr>
                                    <th style="text-align:left;">IBAN No. :</th>
                                    <td><?= $bank_account->iban  ?></td>
                                </tr>
                            </table>
                            <br />
                            <p class="m-0">
                                This is a computer generated invoice and requires no signature.
                            </p>
                            <p class="m-0">
                                For <?= $inv->job->company->title; ?>
                                <br />
                                THANK YOU FOR YOUR BUSINESS!
                            </p>
                        </td>
                    </tr>
                    <tr style="border-top: 1px solid #000;">
                        <td class="text-center">
                            D-36, Block-2, Clifton, Karachi, Pakistan. Tel: +92-21-35878094-95-96, Fax: +92-21-35823438, 35361041<br /> Email: ifo@bilal-group.com, Web: www.bilal-group.com
                        </td>
                    </tr>
                </table>
            </div>
        </div>

    <?php } else { ?>

        <div class="row">
            <div class="col-12">
                <form method="post" action="<?= route('invoice-generate-summary-pdf', [$id]) ?>" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header border-bottom">
                            <h4>Generate Invoie: </h4>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="tax_invoice">Invoice Type</label>
                                        <select class="form-control select2" id="tax_invoice" name="tax_invoice">
                                            <option value="1">TAX Included Invoice</option>
                                            <option value="0">TAX Excluded Invoice</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="bank_account_id">Bank Account</label>
                                        <select class="form-control select2" id="bank_account_id" name="bank_account_id">
                                            <?php
                                            if ($bank_accounts) {
                                                foreach ($bank_accounts as $bank_account) {
                                            ?>
                                                    <option value="<?= $bank_account->id; ?>"><?= $bank_account->title . ': ' . $bank_account->iban . ' ( ' . $bank_account->bank . ' ) '; ?></option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer border-top">
                            <div class="row">
                                <div class="col-12 text-right">
                                    <button type="submit" name="submit" value="submit" class="btn btn-primary">Download PDF</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    <?php } ?>

</x-layout-admin>