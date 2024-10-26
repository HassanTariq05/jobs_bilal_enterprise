<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tank extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'fuel_type_id',
        'title',
        'location',
        'capacity',
        'remarks',
    ];

    function user()
    {
        return $this->belongsTo(User::class);
    }

    function fuel_type()
    {
        return $this->belongsTo(FuelType::class);
    }

}
