<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobBillPaymentDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'job_bill_payment_id',
        'job_bill_id',
        'sales_tax_with_held',
        'income_tax_with_held',
        'account_title_id',
        'adjustment_amount',
        'paid_amount',
        'total',
/*
        'job_bill_payment_id',
        'job_bill_id',
        'paid_amount',
        */
    ];

    
    public function job_bill_payment()
    {
        return $this->belongsTo(JobBillPayment::class);
    }

    public function job_bill()
    {
        return $this->belongsTo(JobBill::class);
    }

    public function account_title()
    {
        return $this->belongsTo(AccountTitle::class);
    }

}
