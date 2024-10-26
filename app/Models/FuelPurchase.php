<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FuelPurchase extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $fillable = [
        'party_id',
        'fuel_type_id',
        'tank_id',
        'qty',
        'rate',
        'amount',
        'delivery_date',
        'freight_charges',
        'remarks'
    ];

    function party()
    {
        return $this->belongsTo(Party::class);
    }

    function fuel_type()
    {
        return $this->belongsTo(FuelType::class);
    }

    function tank()
    {
        return $this->belongsTo(Tank::class);
    }


}
