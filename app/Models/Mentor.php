<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mentor extends Model
{
    use HasFactory;

    protected $primaryKey = 'mentor_id';

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'email',
        'no_wa',
        'status_approval',
        'alasan_tolak',
        'tgl_persetujuan',
    ];

    protected $casts = [
        'tgl_persetujuan' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function murids()
    {
        return $this->hasMany(Murid::class, 'mentor_id', 'mentor_id');
    }

    public function leaderboards()
    {
        return $this->hasMany(Leaderboard::class, 'mentor_id', 'mentor_id');
    }

    public function permintaanBimbingans()
    {
        return $this->hasMany(PermintaanBimbingan::class, 'mentor_id', 'mentor_id');
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('status_approval', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status_approval', 'pending');
    }
}
