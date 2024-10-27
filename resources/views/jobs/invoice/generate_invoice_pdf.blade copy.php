<!DOCTYPE html>
<html>

<head>
    <title>Job Invoice</title>

    <style>
        .table-invoice td,
        .table-invoice th {
            height: 15px !important;
            padding-left: 5px !important;
            padding-right: 5px !important;
        }

        .border {
            border: 1px solid #000 !important;
        }

        td.nop {
            padding: 0px !important;
        }

        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 1rem;
            font-size: 14px;
            border-spacing: 0px;
            border-collapse: collapse;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .font-weight-bold {
            font-weight: bold;
        }

        .h2 {
            font-size: 25px;
        }

        .m-0 {
            margin: 0px;
        }
    </style>

</head>

<body>
    <?php $totals = $inv->job_invoice_totals(); ?>
    <table class="table">
        <tr>
            <td>
                <table class="table">
                    <tr>
                        <td>
                            <img style="height:60px;" src="<?= getFromStorage($inv->job->company->logo) ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size:22px;" class="text-center font-weight-bold">
                            SALES TAX INVOICE
                        </td>
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
                                    <td style="width: 70px;">Invoice No.:</td>
                                    <td><?= $inv->inv_no ?></td>
                                </tr>
                                <tr>
                                    <td>Name:</td>
                                    <td><?= $inv->party->title ?></td>
                                </tr>
                                <tr>
                                    <td>Address:</td>
                                    <td><?= $inv->party->address ?></td>
                                </tr>
                                <tr>
                                    <td>NTN #:</td>
                                    <td><?= $inv->party->ntn ?></td>
                                </tr>
                            </table>
                        </td>
                        <td class="nop" style="vertical-align: top;width:150px;">
                            <table class="table table-invoice">
                                <tr>
                                    <td style="width: 50px;">Date:</td>
                                    <td><?= date_format($inv->created_at, "d-m-Y") ?></td>
                                </tr>
                                <tr>
                                    <td>NTN #:</td>
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
                        <?php
                        $exrows = 20;
                        /*
                        foreach ($inv->items as $i) { ?>
                            <tr>
                                <td><?= $i->account_title->title ?> : <?= $i->description ?></td>
                                <td class="text-center"><?= $i->qty ?></td>
                                <td class="text-right"><?= amount($i->rate, 0) ?></td>
                                <td class="text-right"><?= amount($i->amount, 0) ?></td>
                            </tr>
                        <?php } */ 

                        for($x=1;$x<=$exrows;$x++){
                            echo 
                                "<tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>";
                        }

                        ?>
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
                <table>
                    <tr>
                        <th colspan="2" style="text-align: left;">Beneficiary Details:</th>
                    </tr>
                    <tr>
                        <th style="text-align:left;">Bank Name :</th>
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
</body>

</html>