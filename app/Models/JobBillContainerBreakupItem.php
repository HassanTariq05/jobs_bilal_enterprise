<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class JobBillContainerBreakupItem extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $fillable = [
        'job_bill_container_breakup_id',

        'bl_no',
        'container_no',
        'size',
        'status',
        'vehicle_no',
        'trucking_mode',
        'date',
        'loading_port',
        'off_loading_port',
        'party',
        'remarks',
        
        'rate',
        'qty'
    ];

    public function job_bill_container_breakup(){
        return $this->belongsTo(JobBillContainerBreakup::class);
    }


}
