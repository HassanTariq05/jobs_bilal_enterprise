<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobFile extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'job_id',
        'title',
        'ext',
        'file_path'
    ];


    public function job()
    {
        return $this->belongsTo(Job::class);
    }


}
