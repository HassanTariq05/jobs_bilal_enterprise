<?php

namespace App\Models;

use App\Models\PartyType;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Party extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'party_type_id',
        'short_name',
        'title',
        'slug',
        'address',
        'contact',
        'email',
        'contact_person',
        'bank_name',
        'iban',
        'ntn',
    ];
    
    public function types()
    {
        return PartyType::whereIn('id', explode(',', $this->party_type_id))->get();
    }

    public function booking()
    {
        return $this->hasMany(Booking::class, 'customer');
    }

}
