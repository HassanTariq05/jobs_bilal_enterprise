<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class JobBillFile extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'job_bill_id',
        'title',
        'ext',
        'file_path'
    ];

    public function job_bill()
    {
        return $this->belongsTo(JobBill::class);
    }

}
