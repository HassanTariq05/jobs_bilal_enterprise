<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class JobInvoiceContainerBreakup extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'job_invoice_id',
        'job_invoice_detail_id',
        'sales_tax_territory_id',
        'account_title_id',
        'container_item_code',
        'rate',
        'qty',
        'amount',
        'tax_percentage',
        'tax',
        'net',
        'description',
    ];


    public function job_invoice(){
        return $this->belongsTo(JobInvoice::class);
    }

    public function job_invoice_detail(){
        return $this->belongsTo(JobInvoiceDetail::class);
    }

    public function sales_tax_territory(){
        return $this->belongsTo(SalesTaxTerritory::class);
    }

    public function account_title(){
        return $this->belongsTo(AccountTitle::class);
    }

    public function items(){
        return $this->hasMany(JobInvoiceContainerBreakupItem::class);
    }

    public function get_items_total(){
        $sum = JobInvoiceContainerBreakupItem::where('job_invoice_container_breakup_id', $this->id)->SUM('rate');
        return $sum;
    }
    public function get_qty_total(){
        $qty = JobInvoiceContainerBreakupItem::where('job_invoice_container_breakup_id', $this->id)->COUNT('id');
        return $qty;
    }
    public function get_rate(){
        $output = 0;
        $record = JobInvoiceContainerBreakupItem::select('rate')->where('job_invoice_container_breakup_id', $this->id)->first();
        if($record){
            $output =$record->rate;
        }
        return $output;
    }

    public function update_container_breakup_totals(){
        $record = JobInvoiceContainerBreakup::find($this->id);
        $sum = $this->get_items_total();
        $qty = $this->get_qty_total();
        $rate = $this->get_rate();
        $data = [
            'qty'=>$qty,
            'rate'=>$rate,
            'amount'=>$sum,
            'net'=>($record->tax+$sum)
        ];
        $record->update($data);
        $record = $record->refresh();

        return $record;
    }

}
