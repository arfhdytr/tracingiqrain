<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisGame extends Model
{
    use HasFactory;

    protected $primaryKey = 'jenis_game_id';

    protected $fillable = [
        'tingkatan_id',
        'nama_game',
        'poin_maksimal',
        'deskripsi',
    ];

    public function tingkatanIqra()
    {
        return $this->belongsTo(TingkatanIqra::class, 'tingkatan_id', 'tingkatan_id');
    }

    public function hasilGames()
    {
        return $this->hasMany(HasilGame::class, 'jenis_game_id', 'jenis_game_id');
    }
}
