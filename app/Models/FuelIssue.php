<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FuelIssue extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $fillable = [
        'tank_id',
        'fleet_id',
        'operation_id',
        'fill_date',
        'qty',
        'driver',
        'odometer_reading',
        'remarks'
    ];

    function tank()
    {
        return $this->belongsTo(Tank::class);
    }

    function fleet()
    {
        return $this->belongsTo(Fleet::class);
    }

    function operation()
    {
        return $this->belongsTo(Operation::class);
    }


}
