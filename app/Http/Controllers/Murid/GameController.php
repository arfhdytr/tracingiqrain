<?php

namespace App\Http\Controllers\Murid;

use App\Http\Controllers\Controller;
use App\Models\TingkatanIqra;
use App\Models\JenisGame;
use App\Models\GameStatic;
use App\Models\SoalDragDrop;
use App\Models\HasilGame;
use App\Models\Leaderboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
{
    public function index($tingkatan_id)
    {
        $tingkatan = TingkatanIqra::findOrFail($tingkatan_id);
        $jenisGames = JenisGame::all();

        return view('pages.murid.games.index', compact('tingkatan', 'jenisGames'));
    }

    public function memoryCard($tingkatan_id)
    {
        $tingkatan = TingkatanIqra::with('materiPembelajarans')->findOrFail($tingkatan_id);
        $gameStatic = GameStatic::where('tingkatan_id', $tingkatan_id)
            ->whereHas('jenisGame', function ($q) {
                $q->where('nama_game', 'Memory Card');
            })->first();

        $materiPembelajarans = $tingkatan->materiPembelajarans->take(6); // 6 pairs = 12 cards

        return view('pages.murid.games.memory-card', compact('tingkatan', 'materiPembelajarans', 'gameStatic'));
    }

    public function tracing($tingkatan_id)
    {
        $tingkatan = TingkatanIqra::with('materiPembelajarans')->findOrFail($tingkatan_id);
        $gameStatic = GameStatic::where('tingkatan_id', $tingkatan_id)
            ->whereHas('jenisGame', function ($q) {
                $q->where('nama_game', 'Tracking');
            })->first();

        $materiPembelajarans = $tingkatan->materiPembelajarans;

        return view('pages.murid.games.tracing', compact('tingkatan', 'materiPembelajarans', 'gameStatic'));
    }

    public function labirin($tingkatan_id)
    {
        $tingkatan = TingkatanIqra::with('materiPembelajarans')->findOrFail($tingkatan_id);
        $gameStatic = GameStatic::where('tingkatan_id', $tingkatan_id)
            ->whereHas('jenisGame', function ($q) {
                $q->where('nama_game', 'Labirin');
            })->first();

        $materiPembelajarans = $tingkatan->materiPembelajarans;

        return view('pages.murid.games.labirin', compact('tingkatan', 'materiPembelajarans', 'gameStatic'));
    }

    public function dragDrop($tingkatan_id)
    {
        $tingkatan = TingkatanIqra::findOrFail($tingkatan_id);
        $soals = SoalDragDrop::where('tingkatan_id', $tingkatan_id)
            ->where('status_approval', 'approved')
            ->inRandomOrder()
            ->limit(10)
            ->get();

        $jenisGame = JenisGame::where('nama_game', 'Kuis Drag & Drop')->first();

        return view('pages.murid.games.drag-drop', compact('tingkatan', 'soals', 'jenisGame'));
    }

    public function saveScore(Request $request)
    {
        $request->validate([
            'jenis_game_id' => 'required|exists:jenis_games,jenis_game_id',
            'skor' => 'required|integer|min:0',
            'total_poin' => 'required|integer|min:0',
        ]);

        $murid = Auth::user()->murid;

        // Save hasil game
        $hasilGame = HasilGame::create([
            'murid_id' => $murid->murid_id,
            'jenis_game_id' => $request->jenis_game_id,
            'soal_id' => $request->soal_id ?? null,
            'game_static_id' => $request->game_static_id ?? null,
            'skor' => $request->skor,
            'total_poin' => $request->total_poin,
            'dimainkan_at' => now(),
        ]);

        // Update leaderboard
        $this->updateLeaderboard($murid->murid_id);

        return response()->json([
            'success' => true,
            'hasil_game_id' => $hasilGame->hasil_game_id
        ]);
    }

    private function updateLeaderboard($murid_id)
    {
        // Calculate total points from all games
        $totalPoin = HasilGame::where('murid_id', $murid_id)->sum('total_poin');

        $murid = \App\Models\Murid::find($murid_id);

        // Update global leaderboard
        Leaderboard::updateOrCreate(
            [
                'murid_id' => $murid_id,
                'mentor_id' => null,
            ],
            [
                'total_poin_semua_game' => $totalPoin,
            ]
        );

        // Update mentor leaderboard if murid has mentor
        if ($murid->mentor_id) {
            Leaderboard::updateOrCreate(
                [
                    'murid_id' => $murid_id,
                    'mentor_id' => $murid->mentor_id,
                ],
                [
                    'total_poin_semua_game' => $totalPoin,
                ]
            );
        }

        // Recalculate rankings
        $this->recalculateRankings();
    }

    private function recalculateRankings()
    {
        // Global rankings
        $globalLeaderboards = Leaderboard::whereNull('mentor_id')
            ->orderByDesc('total_poin_semua_game')
            ->get();

        foreach ($globalLeaderboards as $index => $leaderboard) {
            $leaderboard->update(['ranking_global' => $index + 1]);
        }

        // Mentor-specific rankings
        $mentors = Leaderboard::whereNotNull('mentor_id')
            ->distinct('mentor_id')
            ->pluck('mentor_id');

        foreach ($mentors as $mentor_id) {
            $mentorLeaderboards = Leaderboard::where('mentor_id', $mentor_id)
                ->orderByDesc('total_poin_semua_game')
                ->get();

            foreach ($mentorLeaderboards as $index => $leaderboard) {
                $leaderboard->update(['ranking_mentor' => $index + 1]);
            }
        }
    }
}
