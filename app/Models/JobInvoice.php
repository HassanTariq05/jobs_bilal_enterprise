<?php

namespace App\Models;

use App\Models\JobInvoiceReceiptDetail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobInvoice extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'job_id',
        'party_id',
        'inv_date',
        'inv_no',
    ];

    public function party()
    {
        return $this->belongsTo(Party::class);
    }

    public static function parties()
    {
        $where = " id IN (SELECT party_id FROM job_invoices) ";
        return Party::whereRaw($where)->get();
    }

    public function items()
    {
        return $this->hasMany(JobInvoiceDetail::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function job_invoice_details()
    {
        return $this->hasMany(JobInvoiceDetail::class);
    }

    public function job_invoice_totals()
    {
        $totals = ['amount' => 0, 'tax' => 0, 'net' => 0];
        foreach ($this->job_invoice_details as $i) {
            $totals['amount'] += $i->amount;
            $totals['tax'] += $i->tax;
            $totals['net'] += $i->net;
        }
        return $totals;
    }

    public function job_invoice_total_received()
    {
        $received = 0;
        $received = JobInvoiceReceiptDetail::where('job_invoice_id', $this->id)->sum('total');
        return $received;
    }

    /*
    public function job_invoice_total_received()
    {
        $received = 0;
        $received = JobInvoiceReceiptDetail::where('job_invoice_id', $this->id)->sum('received_amount');
        return $received;
    }
    */

    public function job_invoice_balance()
    {
        $totals = $this->job_invoice_totals();
        $received = $this->job_invoice_total_received();
        return ($totals['net']-$received);
    }

    public function job_invoice_receipt_detail()
    {
        return JobInvoiceReceiptDetail::where('job_invoice_id', $this->id)->get();
    }

    public function receipt_details()
    {
        return JobInvoiceReceiptDetail::where('job_invoice_id', $this->id)->get();
    }


    public function files()
    {
        return $this->hasMany(JobInvoiceFile::class);
    }


}
