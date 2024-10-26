<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobBillPayment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'payment_no',
        'document_date',
        'sales_tax_territory_id',
        'bank_id',
        'instrument_amount',
        'instrument_number',
        'instrument_date',
        'paid_to',
        'bank_account_id',
        'payment_mode_id',

        /*
        'document_date',
        'payment_no',
        'sales_tax_with_held',
        'income_tax_with_held',
        'sales_tax_territory_id',
        'account_title_id',
        'adjustment_amount',
        'bank_id',
        'instrument_amount',
        'instrument_number',
        'payment_mode_id',
        'instrument_date',
        'bank_account_id'
        */
    ];


    public function items()
    {
        return $this->hasMany(JobBillPaymentDetail::class);
    }

    public function bills_numbers()
    {
        $output = [];
        $items = $this->items;
        if($items->count()){
        foreach($items as $item)
        {
            $output[] = $item->job_bill->bill_no; 
        }
        }
        return $output;
    }

    public function sales_tax_territory()
    {
        return $this->belongsTo(SalesTaxTerritory::class);
    }

    public function account_title()
    {
        return $this->belongsTo(AccountTitle::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function bank_account()
    {
        return $this->belongsTo(BankAccount::class);
    }

    public function payment_mode()
    {
        return $this->belongsTo(PaymentMode::class);
    }



}
