<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingContainers extends Model
{
    use HasFactory;
    protected $fillable = [
        'booking',
        'bl_no',
        'container_no',
        'size',
        'status',
        'vehicle_no',
        'trucking_mode',
        'date',
        'loading_port',
        'off_loading_port',
        'party',
        'remarks',
        'container_weight',
        'cross_stuffing_status',
        'detention_start_date',
    
    ];
    
}
