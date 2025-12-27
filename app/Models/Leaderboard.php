<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leaderboard extends Model
{
    use HasFactory;

    protected $primaryKey = 'leaderboard_id';

    protected $fillable = [
        'murid_id',
        'mentor_id',
        'total_poin_semua_game',
        'ranking_global',
        'ranking_mentor',
    ];

    public function murid()
    {
        return $this->belongsTo(Murid::class, 'murid_id', 'murid_id');
    }

    public function mentor()
    {
        return $this->belongsTo(Mentor::class, 'mentor_id', 'mentor_id');
    }

    // Scopes
    public function scopeGlobal($query)
    {
        return $query->whereNull('mentor_id');
    }

    public function scopeByMentor($query, $mentorId)
    {
        return $query->where('mentor_id', $mentorId);
    }

    public function scopeTopRanking($query, $limit = 10)
    {
        return $query->orderBy('ranking_global')->limit($limit);
    }

     public static function refreshAllRankings()
    {
        //Hitung Ulang Ranking GLOBAL
        $globalLeaderboards = self::orderByDesc('total_poin_semua_game')->get();
        
        foreach ($globalLeaderboards as $index => $leaderboard) {
            // Update ranking_global (1, 2, 3...)
            // Kita pakai where agar spesifik update baris ini saja
            self::where('leaderboard_id', $leaderboard->leaderboard_id)
                ->update(['ranking_global' => $index + 1]);
        }

        //Hitung Ulang Ranking MENTOR
        //Ambil semua ID mentor yang ada di tabel leaderboard
        $mentorIds = self::whereNotNull('mentor_id')
            ->distinct()
            ->pluck('mentor_id');

        foreach ($mentorIds as $mentorId) {
            // Ambil murid-murid milik mentor ini, urutkan skor tertinggi
            $mentorGroup = self::where('mentor_id', $mentorId)
                ->orderByDesc('total_poin_semua_game')
                ->get();
            
            // Update ranking_mentor mereka (1, 2, 3...)
            foreach ($mentorGroup as $index => $lb) {
                self::where('leaderboard_id', $lb->leaderboard_id)
                    ->update(['ranking_mentor' => $index + 1]);
            }
        }
    }

}
