<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'short_name',
        'title',
        'slug',
        'address',
    ];


    public function booking()
    {
        return $this->hasMany(Booking::class, 'location');
    }

}
