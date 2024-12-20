<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPerformance extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'user_id',
        'file_original_name',
        'file_original_ext',
        'file_temp_name',
        'stored_file',
        'performance_type'
    ];

    public function items()
    {
        return $this->hasMany(JobPerformanceSheetData::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }


}
