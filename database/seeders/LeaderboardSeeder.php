<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Murid;
use App\Models\HasilGame;
use App\Models\Leaderboard;
use Illuminate\Support\Facades\DB;

class LeaderboardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Hitung total poin untuk setiap murid berdasarkan HasilGame
        $scores = HasilGame::select(
                'murid_id',
                DB::raw('SUM(total_poin) as total_skor')
            )
            ->groupBy('murid_id')
            ->orderBy('total_skor', 'desc')
            ->get();

        // Ambil semua murid
        $allMurids = Murid::all()->keyBy('murid_id');

        // Loop dan masukkan/update leaderboard untuk murid yang punya hasil game
        foreach ($scores as $index => $score) {
            $murid = $allMurids->get($score->murid_id);

            Leaderboard::updateOrCreate(
                ['murid_id' => $score->murid_id],
                [
                    'mentor_id' => $murid->mentor_id,
                    'total_poin_semua_game' => $score->total_skor,
                    'ranking_global' => $index + 1,
                    'ranking_mentor' => 0,
                ]
            );
        }

        // Untuk murid yang belum punya HasilGame, buat leaderboard dengan poin 0
        foreach ($allMurids as $murid) {
            if (!$scores->contains('murid_id', $murid->murid_id)) {
                Leaderboard::updateOrCreate(
                    ['murid_id' => $murid->murid_id],
                    [
                        'mentor_id' => $murid->mentor_id,
                        'total_poin_semua_game' => 0,
                        'ranking_global' => 0,
                        'ranking_mentor' => 0,
                    ]
                );
            }
        }

        $this->command->info('Leaderboard updated successfully!');
    }
}
