<div>

    <div id="accordion">

        <?php
        if (COUNT($receipts)) {
            $c = 1;
            foreach ($receipts as $row) {
        ?>
                <div class="accordion bg-light">
                    <div class="accordion-header collapsed" role="button" data-toggle="collapse" data-target="#panel-body-<?= $c ?>" aria-expanded="true">
                        <div class="row">
                            <div class="col-md-4">
                                Document Date : <?= $row->document_date ?>
                            </div>
                            <div class="col-md-4">
                                Receipt # : <?= $row->receipt_no ?>
                            </div>
                            <div class="col-md-4">
                                Payment Mode : <?= $row->payment_mode->title ?>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-body collapse" id="panel-body-<?= $c ?>" data-parent="#accordion">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="font-weight-bold">Sales Tax Withheld</div>
                                <div><?= $row->sales_tax_with_held ?></div>
                            </div>
                            <div class="col-md-3">
                                <div class="font-weight-bold">Income Tax Withheld</div>
                                <div><?= $row->income_tax_with_held ?></div>
                            </div>
                            <div class="col-md-3">
                                <div class="font-weight-bold">Sales Tax Territory</div>
                                <div>
                                    <?php  
                                        if($row->sales_tax_territory){
                                            echo $row->sales_tax_territory->title;
                                        }
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="font-weight-bold">Account Title</div>
                                <div>
                                    <?php  
                                        if($row->account_title){
                                            echo $row->account_title->title;
                                        }
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="font-weight-bold">Adjustment Amount</div>
                                <div><?= amount($row->adjustment_amount) ?></div>
                            </div>
                            <div class="col-md-3">
                                <div class="font-weight-bold">Bank</div>
                                <div><?= $row->bank->title ?></div>
                            </div>
                            <div class="col-md-3">
                                <div class="font-weight-bold">Instrument Amount</div>
                                <div><?= amount($row->instrument_amount) ?></div>
                            </div>
                            <div class="col-md-3">
                                <div class="font-weight-bold">Instrument #</div>
                                <div><?= $row->instrument_number ?></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-sm bg-white text-dark mt-3 shadow">
                                    <thead>
                                        <tr>
                                            <th colspan="3">
                                                Invoices Details
                                            </th>
                                        </tr>
                                        <tr>
                                            <th class="col-md-1 text-center">#</th>
                                            <th class="col-md-4 text-center">Invoice #</th>
                                            <th class="col-md-6 text-right">Received Amount</th>
                                        </tr>
                                    </thead>
                                    <?php $total = 0;
                                    if ($row->items) {
                                        $c = 1;
                                        foreach ($row->items as $i) {
                                            $total += $i->received_amount;
                                    ?>
                                            <tr>
                                                <td class="text-center"><?= $c ?></td>
                                                <td class="text-center"><?= $i->job_invoice->inv_no ?></td>
                                                <td class="text-right"><?= amount($i->received_amount) ?></td>
                                            </tr>
                                        <?php $c++;
                                        } ?>

                                        <tr class="bg-light shadow">
                                            <th colspan="2" class="text-right">Total</th>
                                            <th class="text-right"><?= amount($total) ?></th>
                                        </tr>

                                    <?php
                                    } ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
        <?php $c++;
            }
        }else{ 
        ?>
        
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-danger">Sorry! records not found.</div>
                </div>
            </div>

        <?php 
        }
        ?>
    </div>
</div>