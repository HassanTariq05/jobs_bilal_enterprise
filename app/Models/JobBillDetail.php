<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobBillDetail extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'job_bill_id',
        'account_title_id',
        'sales_tax_territory_id',
        'container_item_code',
        'rate',
        'qty',
        'amount',
        'tax_percentage',
        'tax',
        'net',
        'description',
        'is_manual',
    ];


    public function account_title()
    {
        return $this->belongsTo(AccountTitle::class);
    }

    public function job_invoice()
    {
        return $this->belongsTo(JobInvoice::class);
    }

}
