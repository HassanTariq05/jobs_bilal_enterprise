<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JournalVoucher extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'voucher_type_id',
        'company_id',
        'account_title_id',
        'location_id',
        'voucher_no',
        'date',
        'cheque_no',
        'cheque_date',
        'pay_to'
    ];


    public function voucher_type()
    {
        return $this->belongsTo(VoucherType::class);
    }

    public function items()
    {
        return $this->hasMany(JournalVoucherItem::class);
    }

}
