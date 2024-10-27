<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContainerSize extends Model
{
    use HasFactory;
    protected $fillable = [
        "container-size",
        "created_by",
        "updated_by"
    ];
}
