<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Haruncpi\LaravelIdGenerator\IdGenerator;

use App\Models\JobType;
use App\Models\Company;
use App\Models\JobInvoiceReceipt;
use App\Models\JobBillPayment;

use App\Models\JobInvoiceContainerBreakup;
use App\Models\JobInvoiceContainerBreakupItem;

class Job extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'job_no',
        'party_id',
        'company_id',
        'location_id',
        'job_type_id',
        'document_date',
        'approved',
        'remarks',
        'files'
    ];




    public function job_type()
    {
        return $this->belongsTo(JobType::class);
    }

    public function job_status()
    {
        return $this->belongsTo(JobStatus::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function party()
    {
        return $this->belongsTo(Party::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function job_invoices()
    {
        return $this->hasMany(JobInvoice::class);
    }

    public function job_bills()
    {
        return $this->hasMany(JobBill::class);
    }

    public function files()
    {
        return $this->hasMany(JobFile::class);
    }

    public function job_totals()
    {
        $totals = ['receivable' => 0, 'payable' => 0, 'net' => 0];
        foreach ($this->job_invoices as $i) {
            $t = $i->job_invoice_totals();
            //$totals['receivable'] += $t['net'];
            $totals['receivable'] += $t['amount'];
        }

        foreach ($this->job_bills as $b) {
            $b = $b->job_bill_totals();
            //$totals['payable'] += $b['net'];
            $totals['payable'] += $b['amount'];
        }

        return $totals;
    }

    public function job_receipts()
    {
        $output = [];

        $invoices = $this->job_invoices;

        if ($invoices) {
            $receipt_ids = [];
            foreach ($invoices as $inv) {
                $receipt_details = $inv->receipt_details();
                if ($receipt_details->count()) {

                    foreach ($receipt_details as $receipt_detail) {
                        $receipt_ids[] = $receipt_detail->job_invoice_receipt_id;
                    }

                    $output = JobInvoiceReceipt::whereIn('id', $receipt_ids)->get();
                    /*
                $receipts = JobInvoiceReceipt::whereIn('id', $receipt_ids)->get();
                    ///if (COUNT($receipts)) {
                    if ($receipts->count()) {
                        $c = 0;
                        foreach ($receipts as $receipt)
                        {

                            $payment_mode = $sales_tax_territory = $account_title = $bank_title = '';
                            if ($receipt->payment_mode_id) {
                                $payment_mode = $receipt->payment_mode->title;
                            }
                            if ($receipt->sales_tax_territory_id) {
                                $sales_tax_territory = $receipt->sales_tax_territory->title;
                            }
                            if ($receipt->account_title_id) {
                                $account_title = $receipt->account_title->title;
                            }
                            if ($receipt->bank_id) {
                                $bank_title = $receipt->bank->title;
                            }

                            $output[$c]['document_date'] = $receipt->document_date;
                            $output[$c]['receipt_no'] = $receipt->receipt_no;
                            $output[$c]['payment_mode'] = $payment_mode;
                            $output[$c]['sales_tax_with_held'] = $receipt->sales_tax_with_held;
                            $output[$c]['income_tax_with_held'] = $receipt->income_tax_with_held;
                            $output[$c]['sales_tax_territory'] = $sales_tax_territory;
                            $output[$c]['account_title'] = $account_title;
                            $output[$c]['adjustment_amount'] = $receipt->adjustment_amount;
                            $output[$c]['bank_title'] = $bank_title;
                            $output[$c]['instrument_amount'] = $receipt->instrument_amount;
                            $output[$c]['instrument_number'] = $receipt->instrument_number;
                            $output[$c]['items'] = $receipt->items;
                            $c++;
                            
                        }
                    }
                    */
                }
            }
        }
        return $output;
    }

    public function job_payments()
    {
        $output = [];

        $bills = $this->job_bills;

        if ($bills) {
            $c = 0;
            foreach ($bills as $bill) {
                $payment_details = $bill->payment_details();
                if (COUNT($payment_details)) {

                    foreach ($payment_details as $payment_detail) {
                        $payment_ids[] = $payment_detail->job_bill_payment_id;
                    }

                    $output = JobBillPayment::whereIn('id', $payment_ids)->get();
                    /*
                    $payments = JobBillPayment::whereIn('id', $payment_ids)->get();
                    if (COUNT($payments)) {
                        $c = 0;
                        foreach ($payments as $payment) {
                            $payment_mode = $sales_tax_territory = $account_title = $bank_title = '';
                            if ($payment->payment_mode_id) {
                                $payment_mode = $payment->payment_mode->title;
                            }
                            if ($payment->sales_tax_territory_id) {
                                $sales_tax_territory = $payment->sales_tax_territory->title;
                            }
                            if ($payment->account_title_id) {
                                $account_title = $payment->account_title->title;
                            }
                            if ($payment->bank_id) {
                                $bank_title = $payment->bank->title;
                            }
                            $output[$c]['document_date'] = $payment->document_date;
                            $output[$c]['payment_no'] = $payment->payment_no;
                            $output[$c]['payment_mode'] = $payment_mode;
                            $output[$c]['sales_tax_with_held'] = $sales_tax_territory;
                            $output[$c]['income_tax_with_held'] = $payment->income_tax_with_held;
                            $output[$c]['sales_tax_territory'] = $payment->sales_tax_with_held;
                            $output[$c]['account_title'] = $account_title;
                            $output[$c]['adjustment_amount'] = $payment->adjustment_amount;
                            $output[$c]['bank_title'] = $bank_title;
                            $output[$c]['instrument_amount'] = $payment->instrument_amount;
                            $output[$c]['instrument_number'] = $payment->instrument_number;
                            $output[$c]['items'] = $payment->items;
                            $c++;
                        }
                    }
                    */
                }
            }
        }
        return $output;
    }

/*
    public function get_job_invoice_container_breakup_items_array($job_id=0)
    {
        $invoices = $this->job_invoices();
    }
    public function get_job_invoice_container_breakups($job_id=0)
    {
        //JobBillContainerBreakup::
    }
    public static function get_job_invoice_container_breakup_items($job_id=0)
    {
        $result = JobInvoiceContainerBreakupItem::whereRaw(" job_invoice_container_breakup_id IN (SELECT jicb.id FROM job_invoice_container_breakups AS jicb WHERE jicb.job_invoice_id IN (SELECT ji.id FROM job_invoices AS ji WHERE ji.job_id=$job_id) ) ")->get();
        return $result;
    }
    public function job_receipts()
    {
        $output = [];

        $invoices = $this->job_invoices;

        if ($invoices) {
            $c = 0;
            foreach ($invoices as $inv) {
                $receipt_details = $inv->receipt_details();

                echo "<pre>";
                print_r($receipt_details);
                exit();

                if (COUNT($receipt_details)) {

                    $receipts_items = [];
                    $ic = 0;
                    $receipt = [];
                    foreach ($receipt_details as $receipt_detail) 
                    {
                        $receipts_items[$ic]['inv_no'] = $inv->inv_no;
                        $receipts_items[$ic]['received_amount'] = $receipt_detail->received_amount;
                        $receipt = $receipt_detail->job_invoice_receipt;
                        $ic++;
                    }

                    $payment_mode = $sales_tax_territory = $account_title = $bank_title = '';
                    if($receipt->payment_mode_id){
                        $payment_mode = $receipt->payment_mode->title;
                    }
                    if($receipt->sales_tax_territory_id){
                        $sales_tax_territory = $receipt->sales_tax_territory->title;
                    }
                    if($receipt->account_title_id){
                        $account_title = $receipt->account_title->title;
                    }
                    if($receipt->bank_id){
                        $bank_title = $receipt->bank->title;
                    }
                    $output[$c]['document_date'] = $receipt->document_date;
                    $output[$c]['receipt_no'] = $receipt->receipt_no;
                    $output[$c]['payment_mode'] = $payment_mode;
                    $output[$c]['sales_tax_with_held'] = $sales_tax_territory;
                    $output[$c]['income_tax_with_held'] = $receipt->income_tax_with_held;
                    $output[$c]['sales_tax_territory'] = $receipt->sales_tax_with_held;
                    $output[$c]['account_title'] = $account_title;
                    $output[$c]['adjustment_amount'] = $receipt->adjustment_amount;
                    $output[$c]['bank_title'] = $bank_title;
                    $output[$c]['instrument_amount'] = $receipt->instrument_amount;
                    $output[$c]['instrument_number'] = $receipt->instrument_number;
                    $output[$c]['items'] = $receipts_items;
                    $c++;
                }
            }
        }
        return $output;
    }
    public function job_receipts()
    {
        $output = [];

        $invoices = $this->job_invoices;

        if ($invoices) {
            $receipt_ids = [];
            foreach ($invoices as $inv) {
                $receipt_details = $inv->receipt_details();

                if (COUNT($receipt_details)) {

                    foreach ($receipt_details as $receipt_detail) {
                        $receipt_ids[] = $receipt_detail->job_invoice_receipt_id;
                    }

                    $receipts = JobInvoiceReceipt::whereIn('id', $receipt_ids)->get();
                    if (COUNT($receipts)) {
                        $c = 0;
                        foreach ($receipts as $receipt) {

                            $payment_mode = $sales_tax_territory = $account_title = $bank_title = '';
                            if ($receipt->payment_mode_id) {
                                $payment_mode = $receipt->payment_mode->title;
                            }
                            if ($receipt->sales_tax_territory_id) {
                                $sales_tax_territory = $receipt->sales_tax_territory->title;
                            }
                            if ($receipt->account_title_id) {
                                $account_title = $receipt->account_title->title;
                            }
                            if ($receipt->bank_id) {
                                $bank_title = $receipt->bank->title;
                            }

                            $output[$c]['document_date'] = $receipt->document_date;
                            $output[$c]['receipt_no'] = $receipt->receipt_no;
                            $output[$c]['payment_mode'] = $payment_mode;
                            $output[$c]['sales_tax_with_held'] = $receipt->sales_tax_with_held;
                            $output[$c]['income_tax_with_held'] = $receipt->income_tax_with_held;
                            $output[$c]['sales_tax_territory'] = $sales_tax_territory;
                            $output[$c]['account_title'] = $account_title;
                            $output[$c]['adjustment_amount'] = $receipt->adjustment_amount;
                            $output[$c]['bank_title'] = $bank_title;
                            $output[$c]['instrument_amount'] = $receipt->instrument_amount;
                            $output[$c]['instrument_number'] = $receipt->instrument_number;
                            $output[$c]['items'] = $receipt->items;
                            $c++;
                        }
                    }
                }
            }
        }
        return $output;
    }
    public function job_payments()
    {
        $output = [];
        
        $bills = $this->job_bills;

        if ($bills) {
            $c = 0;
            foreach ($bills as $bill) {
                $payment_details = $bill->payment_details();
                if (COUNT($payment_details)) {

                    $payment_items = [];
                    $ic = 0;
                    $payment = [];
                    foreach ($payment_details as $payment_detail) 
                    {
                        $payment_items[$ic]['bill_no'] = $bill->bill_no;
                        $payment_items[$ic]['paid_amount'] = $payment_detail->paid_amount;
                        $payment = $payment_detail->job_bill_payment;
                        $ic++;
                    }

                    $payment_mode = $sales_tax_territory = $account_title = $bank_title = '';
                    if($payment->payment_mode_id){
                        $payment_mode = $payment->payment_mode->title;
                    }
                    if($payment->sales_tax_territory_id){
                        $sales_tax_territory = $payment->sales_tax_territory->title;
                    }
                    if($payment->account_title_id){
                        $account_title = $payment->account_title->title;
                    }
                    if($payment->bank_id){
                        $bank_title = $payment->bank->title;
                    }
                    $output[$c]['document_date'] = $payment->document_date;
                    $output[$c]['payment_no'] = $payment->payment_no;
                    $output[$c]['payment_mode'] = $payment_mode;
                    $output[$c]['sales_tax_with_held'] = $sales_tax_territory;
                    $output[$c]['income_tax_with_held'] = $payment->income_tax_with_held;
                    $output[$c]['sales_tax_territory'] = $payment->sales_tax_with_held;
                    $output[$c]['account_title'] = $account_title;
                    $output[$c]['adjustment_amount'] = $payment->adjustment_amount;
                    $output[$c]['bank_title'] = $bank_title;
                    $output[$c]['instrument_amount'] = $payment->instrument_amount;
                    $output[$c]['instrument_number'] = $payment->instrument_number;
                    $output[$c]['items'] = $payment_items;
                    $c++;
                }
            }
        }
        return $output;
    }
*/



}
