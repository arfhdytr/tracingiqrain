<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilGame extends Model
{
    use HasFactory;

    protected $primaryKey = 'hasil_game_id';

    protected $fillable = [
        'murid_id',
        'jenis_game_id',
        'skor',
        'total_poin',
        'dimainkan_at',
    ];

    protected $casts = [
        'dimainkan_at' => 'datetime',
    ];

    public function murid()
    {
        return $this->belongsTo(Murid::class, 'murid_id', 'murid_id');
    }

    public function jenisGame()
    {
        return $this->belongsTo(JenisGame::class, 'jenis_game_id', 'jenis_game_id');
    }
}
