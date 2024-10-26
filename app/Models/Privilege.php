<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Privilege extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'privilege_group_id',
        'title',
        'slug',
        'short_title',
        'order_by'
    ];

    public function privilege_group()
    {
        return $this->belongsTo(PrivilegeGroup::class);
    }


}
