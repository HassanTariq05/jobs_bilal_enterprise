<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JournalVoucherItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'journal_voucher_id',
        'account_title_id',
        'location_id',
        'debit',
        'credit',
    ];

    
    public function journal_voucher()
    {
        return $this->belongsTo(JournalVoucher::class);
    }

}
