<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fleet extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $fillable = [
        'fleet_manufacturer_id',
        'fleet_type_id',
        'registration_number',
        'chassis_number',
        'engine_number',
        'model',
        'horsepower',
        'loading_capacity',
        'registration_city',
        'ownership',
        'lifting_capacity',
        'diesel_opening_inventory'
    ];

    function fleetManufacturer()
    {
        return $this->belongsTo(FleetManufacturer::class);
    }

    function fleetType()
    {
        return $this->belongsTo(FleetType::class);
    }

}
