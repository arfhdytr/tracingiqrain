<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Leaderboard;
use App\Models\Murid;

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

    protected static function booted()
    {
        static::saved(function ($hasilGame) {
            $murid = Murid::find($hasilGame->murid_id);

            if ($murid) {
                $totalSkor = self::where('murid_id', $hasilGame->murid_id)->sum('total_poin');

                Leaderboard::updateOrCreate(
                    ['murid_id' => $hasilGame->murid_id],
                    [
                        'mentor_id' => $murid->mentor_id,
                        'total_poin_semua_game' => $totalSkor,
                        'ranking_global' => 0,
                        'ranking_mentor' => 0,
                    ]
                );

                Leaderboard::refreshAllRankings();
            }
        });
    }
}
