<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'username',
        'password',
        'avatar_path',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relationships
    public function admin()
    {
        return $this->hasOne(Admin::class, 'user_id', 'user_id');
    }

    public function mentor()
    {
        return $this->hasOne(Mentor::class, 'user_id', 'user_id');
    }

    public function murid()
    {
        return $this->hasOne(Murid::class, 'user_id', 'user_id');
    }

    // Helper methods
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function isMentor()
    {
        return $this->hasRole('mentor');
    }

    public function isMurid()
    {
        return $this->hasRole('murid');
    }

    public function getAvatarUrlAttribute()
    {
        return $this->avatar_path ? asset('storage/' . $this->avatar_path) : asset('images/avatar/cowo.webp');
    }
}
