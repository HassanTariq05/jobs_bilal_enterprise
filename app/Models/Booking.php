<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = [
        'booking',
        'bl_no',
        'loading_port',
        'off_load',
        'customer',
        'location',
        'date',
        'remarks',
        'job_type'
        
    ];


    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
}
