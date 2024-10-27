<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class JobInvoiceFile extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'job_invoice_id',
        'title',
        'ext',
        'file_path'
    ];


    public function job_invoice()
    {
        return $this->belongsTo(JobInvoice::class);
    }

}
