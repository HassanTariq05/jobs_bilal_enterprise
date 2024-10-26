<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankAccount extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'bank',
        'address',
        'title',
        'iban',
        'company_id',
    ];

    public function company(){
        return $this->belongsTo(Company::class);
    }


}
