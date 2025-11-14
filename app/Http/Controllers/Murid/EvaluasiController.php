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
            $latestResult = HasilGame::where('murid_id', $murid->murid_id)
                ->where('jenis_game_id', $game->jenis_game_id)
                ->latest('dimainkan_at')
                ->first();

            $evaluasiData[] = [
                'game' => $game,
                'result' => $latestResult,
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
