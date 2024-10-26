<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobInvoiceReceiptDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'job_invoice_receipt_id',
        'job_invoice_id',
        'sales_tax_with_held',
        'income_tax_with_held',
        'account_title_id',
        'adjustment_amount',
        'received_amount',
        'total',
    ];

    public function job_invoice_receipt()
    {
        return $this->belongsTo(JobInvoiceReceipt::class);
    }

    public function job_invoice()
    {
        return $this->belongsTo(JobInvoice::class);
    }

    public function account_title()
    {
        return $this->belongsTo(AccountTitle::class);
    }

}
