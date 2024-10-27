<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'email',
        'user_role_id',
        'designation_id',
        'password',
        'status_id',
        'report_to'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
    function designation()
    {
        return $this->belongsTo(Designation::class);
    }
    
    function user_role()
    {
        return $this->belongsTo(UserRole::class);
    }
    
    function lead()
    {
        return $this->belongsTo(User::class, 'report_to', 'id');
    }
    function team()
    {
        return $this->hasMany(User::class, 'id', 'report_to');
    }


}
