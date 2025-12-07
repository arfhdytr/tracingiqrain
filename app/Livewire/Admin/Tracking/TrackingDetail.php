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
            'progressModuls.modul.materiPembelajaran'
        ]);

        $this->calculateStats();
    }

    public function calculateStats()
    {
        // Poin per Game
        $hasilGames = $this->murid->hasilGames;

        $this->poinPerGame = [
            'tracking' => $hasilGames->where('jenis_game_id', 1)->sum('total_poin'),
            'labirin' => $hasilGames->where('jenis_game_id', 3)->sum('total_poin'),
            'memory' => $hasilGames->where('jenis_game_id', 4)->sum('total_poin'),
            'drag_drop' => $hasilGames->where('jenis_game_id', 2)->sum('total_poin'),
        ];

        $this->totalPoin = array_sum($this->poinPerGame);

        $totalModul = 30;
        $modulSelesai = $this->murid->progressModuls->where('status', 'selesai')->count();
        $this->progressModul = $totalModul > 0 ? round(($modulSelesai / $totalModul) * 100) : 0;
    }

    public function render()
    {
        return view('livewire.admin.tracking.tracking-detail');
    }
}
