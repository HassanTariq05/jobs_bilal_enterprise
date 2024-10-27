<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class JobBillContainerBreakup extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $fillable = [
        'job_bill_id',
        'job_bill_detail_id',
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


    public function job_bill(){
        return $this->belongsTo(JobBill::class);
    }

    public function job_bill_detail(){
        return $this->belongsTo(JobBillDetail::class);
    }

    public function sales_tax_territory(){
        return $this->belongsTo(SalesTaxTerritory::class);
    }

    public function account_title(){
        return $this->belongsTo(AccountTitle::class);
    }

    public function items(){
        return $this->hasMany(JobBillContainerBreakupItem::class);
    }

    public function get_items_total(){
        $sum = JobBIllContainerBreakupItem::where('job_bill_container_breakup_id', $this->id)->SUM('rate');
        return $sum;
    }
    public function get_qty_total(){
        $qty = JobBillContainerBreakupItem::where('job_bill_container_breakup_id', $this->id)->COUNT('id');
        return $qty;
    }
    public function get_rate(){
        $output = 0;
        $record = JobBillContainerBreakupItem::select('rate')->where('job_bill_container_breakup_id', $this->id)->first();
        if($record){
            $output =$record->rate;
        }
        return $output;
    }

    public function update_container_breakup_totals(){
        $record = JobBillContainerBreakup::find($this->id);
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
