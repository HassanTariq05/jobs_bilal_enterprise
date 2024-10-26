<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPerformanceSheetData extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_performance_id',
        'job_invoice_detail_id',
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
    ];

    public function job_performance()
    {
        return $this->belongsTo(JobPerformance::class);
    }

    public function account_title()
    {
        return $this->belongsTo(AccountTitle::class);
    }




}
