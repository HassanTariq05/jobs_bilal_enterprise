<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrivilegeGroup extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'privilege_category_id',
        'title',
        'slug',
        'order_by'
    ];

    public function privileges()
    {
        return $this->hasMany(Privilege::class);
    }

    public function privilege_category()
    {
        return $this->belongsTo(PrivilegeCategory::class);
    }


}
