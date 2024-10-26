<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountTitle extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'short_name',
        'account_nature_id',
        'code',
        'title',
        'slug',
    ];

    function account_nature()
    {
        return $this->belongsTo(AccountNature::class);
    }

}
