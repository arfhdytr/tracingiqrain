<?php

namespace App\Http\Controllers\Murid;

use App\Http\Controllers\Controller;
use App\Models\TingkatanIqra;
use App\Models\Leaderboard;
use App\Models\HasilGame;
use App\Models\JenisGame;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvaluasiController extends Controller
{
    public function index($tingkatan_id)
    {
        $tingkatan = TingkatanIqra::findOrFail($tingkatan_id);
        $murid = Auth::user()->murid;

        // Get leaderboard data
        $leaderboardType = request()->get('type', 'global'); // global or mentor

        if ($leaderboardType === 'mentor' && $murid->mentor_id) {
            $leaderboards = Leaderboard::with('murid.user')
                ->where('mentor_id', $murid->mentor_id)
                ->whereNotNull('ranking_mentor')
                ->orderBy('ranking_mentor')
                ->get();

            $myRanking = Leaderboard::where('murid_id', $murid->murid_id)
                ->where('mentor_id', $murid->mentor_id)
                ->first();
        } else {
            $leaderboards = Leaderboard::with('murid.user')
                ->whereNull('mentor_id')
                ->whereNotNull('ranking_global')
                ->orderBy('ranking_global')
                ->get();

            $myRanking = Leaderboard::where('murid_id', $murid->murid_id)
                ->whereNull('mentor_id')
                ->first();
        }

        // Get personal evaluation data
        $jenisGames = JenisGame::all();
        $evaluasiData = [];

       foreach ($jenisGames as $game) {

            // --- LOGIKA BARU ---

            // 1. Ambil semua hasil permainan untuk game ini
            $allResults = HasilGame::where('murid_id', $murid->murid_id)
                ->where('jenis_game_id', $game->jenis_game_id)
                ->get();

            // 2. Hitung total poin dan total jumlah main
            $totalPoinGameIni = $allResults->sum('total_poin');
            $jumlahMain       = $allResults->count();

            // Siapkan variabel default
            $ulasan         = null;
            $resultForView  = null;

            if ($jumlahMain > 0) {
                // Buat objek sederhana agar mudah dibaca di Blade
                $resultForView = (object) [
                    'total_poin' => $totalPoinGameIni, // total semua poin
                    'skor'       => $jumlahMain        // jumlah bermain
                ];

                // Hitung rata-rata dan persentase
                $poinMaksimal = $game->poin_maksimal ?? 100;
                $rataRata     = $totalPoinGameIni / $jumlahMain;
                $persen       = ($rataRata / $poinMaksimal) * 100;

                // Tentukan ulasan berdasarkan persentase rata-rata
                if ($persen >= 90) {
                    $ulasan = 'Luar biasa! Kamu konsisten hebat! 🌟';
                } elseif ($persen >= 75) {
                    $ulasan = 'Bagus sekali! Rata-rata skormu tinggi! 💪';
                } elseif ($persen >= 60) {
                    $ulasan = 'Cukup baik! Terus tingkatkan! 😊';
                } else {
                    $ulasan = 'Tetap semangat! Latihan lagi ya! 🔥';
                }
            }

            // Masukkan ke array evaluasi
            $evaluasiData[] = [
                'game'   => $game,
                'result' => $resultForView,
                'ulasan' => $ulasan,
            ];
        }


        return view('pages.murid.evaluasi.index', compact(
            'tingkatan',
            'leaderboards',
            'myRanking',
            'leaderboardType',
            'evaluasiData'
        ));
    }

    public function leaderboard($tingkatan_id)
    {
        $tingkatan = TingkatanIqra::findOrFail($tingkatan_id);
        $murid = Auth::user()->murid;

        $type = request()->get('type', 'global');

        if ($type === 'mentor' && $murid->mentor_id) {
            $leaderboards = Leaderboard::with('murid.user')
                ->where('mentor_id', $murid->mentor_id)
                ->whereNotNull('ranking_mentor')
                ->orderBy('ranking_mentor')
                ->get();
        } else {
            $leaderboards = Leaderboard::with('murid.user')
                ->whereNull('mentor_id')
                ->whereNotNull('ranking_global')
                ->orderBy('ranking_global')
                ->get();
        }

        return response()->json([
            'leaderboards' => $leaderboards,
            'type' => $type
        ]);
    }
}
