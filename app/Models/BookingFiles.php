<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingFiles extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'booking_id',
        'title',
        'ext',
        'file_path'
    ];


    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }


}
