<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobInvoiceReceipt extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'receipt_no',
        'document_date',
        'sales_tax_territory_id',
        'bank_id',
        'instrument_amount',
        'instrument_number',
        'instrument_date',
        'received_from',
        'bank_account_id',
        'payment_mode_id'
    ];

    public function items()
    {
        return $this->hasMany(JobInvoiceReceiptDetail::class);
    }

    public function invoices_numbers()
    {
        $output = [];
        $items = $this->items;
        if($items->count()){
        foreach($items as $item)
        {
            if($item->job_invoice && $item->job_invoice->inv_no){
                $output[] = $item->job_invoice->inv_no; 
            }
        }
        }
        return $output;
    }

    public function sales_tax_territory()
    {
        return $this->belongsTo(SalesTaxTerritory::class);
    }

    /*
    public function account_title()
    {
        return $this->belongsTo(AccountTitle::class);
    }
    */

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
