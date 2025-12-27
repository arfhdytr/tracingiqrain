<?php

namespace App\Http\Controllers;

use App\Models\HasilGame;
use App\Models\Murid;
use App\Models\User; // <-- Dibutuhkan
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeaderboardController extends Controller
{
    public function index()
    {
        // Query untuk menjumlahkan skor per murid        
        $scores = HasilGame::select(
                'murid_id', 
                DB::raw('SUM(total_poin) as total_skor')
            )
            ->groupBy('murid_id')
            ->orderBy('total_skor', 'desc')
            ->get();

        //Ambil ID murid dari hasil query
        $muridIds = $scores->pluck('murid_id');

        //Ambil data murid DAN relasi user-nya (Eager Loading)
        $murids = Murid::with('user') // Ambil relasi 'user'
                       ->whereIn('murid_id', $muridIds)
                       ->get()
                       ->keyBy('murid_id');

        //Gabungkan data skor, nama, dan avatar
        $rankedPlayers = $scores->map(function ($item, $key) use ($murids) {
            
            $muridName = 'Murid (No User)';
            // Ambil default avatar dari model User
            $defaultAvatar = (new User)->getAvatarUrlAttribute(); 
            $avatarUrl = $defaultAvatar;
            
            // Ambil data murid dari koleksi
            $murid = $murids->get($item->murid_id);

            // Cek apakah muridnya ada DAN relasi user-nya ada
            if ($murid && $murid->user) {
          
                $muridName = $murid->user->username; 
          
                $avatarUrl = $murid->user->avatar_url; 
            }

            return [
                'rank' => $key + 1, // Peringkat
                'name' => $muridName,
                'score' => $item->total_skor,
                'avatar_url' => $avatarUrl, // 
            ];
        });

        // Pisahkan data untuk podium (Top 3)
        $podium = [
            'rank_1' => $rankedPlayers->firstWhere('rank', 1),
            'rank_2' => $rankedPlayers->firstWhere('rank', 2),
            'rank_3' => $rankedPlayers->firstWhere('rank', 3),
        ];

        // Sisa pemain (ranking 4 ke bawah)
        $otherPlayers = $rankedPlayers->where('rank', '>', 3);

        // Kirim ke View
        return view('leaderboard', [ 
            'podium' => $podium,
            'otherPlayers' => $otherPlayers
        ]);
    }
}