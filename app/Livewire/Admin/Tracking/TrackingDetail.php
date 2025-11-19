<?php
// app/Livewire/Admin/Tracking/TrackingDetail.php

namespace App\Livewire\Admin\Tracking;

use App\Models\Murid;
use Livewire\Component;

class TrackingDetail extends Component
{
    public Murid $murid;
    public $totalPoin = 0;
    public $poinPerGame = [];
    public $progressModul = 0;

    public function mount(Murid $murid)
    {
        $this->murid = $murid->load([
            'user',
            'mentor',
            'leaderboards',
            'hasilGames.jenisGame',
            'hasilGames.soalDragDrop',
            'hasilGames.gameStatic',
            'progressModuls.modul.materiPembelajaran'
        ]);

        $this->calculateStats();
    }

    public function calculateStats()
    {
        // Total Poin dari Leaderboard
        $leaderboard = $this->murid->leaderboards->where('mentor_id', null)->first();
        $this->totalPoin = $leaderboard ? $leaderboard->total_poin_semua_game : 0;

        // Poin per Game
        $hasilGames = $this->murid->hasilGames;

        // Group by jenis_game_id dan sum total_poin
        $this->poinPerGame = [
            'tracking' => $hasilGames->where('jenis_game_id', 1)->sum('total_poin'), // Tracking
            'labirin' => $hasilGames->where('jenis_game_id', 3)->sum('total_poin'),  // Labirin
            'memory' => $hasilGames->where('jenis_game_id', 4)->sum('total_poin'),   // Memory Card
            'drag_drop' => $hasilGames->where('jenis_game_id', 2)->sum('total_poin'), // Kuis Drag & Drop
        ];

        // Progress Modul (persentase modul yang selesai)
        $totalModul = $this->murid->progressModuls->count();
        $modulSelesai = $this->murid->progressModuls->where('status', 'selesai')->count();
        $this->progressModul = $totalModul > 0 ? round(($modulSelesai / $totalModul) * 100) : 0;
    }

    public function render()
    {
        return view('livewire.admin.tracking.tracking-detail');
    }
}
