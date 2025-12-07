<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// Kita butuh semua model ini
use App\Models\User;
use App\Models\Murid;
use App\Models\HasilGame;
use App\Models\JenisGame;
use Illuminate\Support\Facades\Hash; // <-- Tambahkan ini
use App\Models\Leaderboard; // <-- TAMBAHKAN INI
use Illuminate\Support\Facades\DB;   // <-- TAMBAHKAN INI

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RolePermissionSeeder::class,
            UserSeeder::class,
            TingkatanIqraSeeder::class,
            JenisGameSeeder::class,   
            MateriPembelajaranSeeder::class,  MateriSeeder::class,              
            VideoPembelajaranSeeder::class,    
            ActivitySeeder::class,             
        ]);

        Murid::factory()
            ->count(20) // Buat 20 Murid (otomatis 20 User baru)
            ->has(
                HasilGame::factory()
                    ->count(5) // Setiap Murid punya 5 riwayat game
                    ->state(function (array $attributes) {
                        // Ambil ID game acak (Ini sudah benar)
                        return ['jenis_game_id' => JenisGame::all()->random()->jenis_game_id];
                    })
            )
            ->create();

        // 3. Buat 1 Jagoan (Kita buat manual biar 100% aman)
        $jagoanUser = User::create([
            'username' => 'JAGOAN_KITA',
            'password' => Hash::make('password'),
            'avatar_path' => null
        ]);

        $jagoanMurid = Murid::create([
            'user_id' => $jagoanUser->user_id,
            'sekolah' => 'Sekolah Juara',
            'preferensi_terisi' => false, // Pastikan kolom ini diisi
        ]);

        HasilGame::factory()
            ->count(10) // Dia main 10x
            ->state(function (array $attributes) {
                return [
                    'total_poin' => 1000, // Skornya selalu tinggi
                    'jenis_game_id' => JenisGame::all()->random()->jenis_game_id
                ];
            })
            ->for($jagoanMurid) // Tautkan ke Murid jagoan
            ->create();

        $scores = HasilGame::select(
                'murid_id', 
                DB::raw('SUM(total_poin) as total_skor')
            )
            ->groupBy('murid_id')
            ->orderBy('total_skor', 'desc')
            ->get();
        
        // Ambil data murid (untuk 'mentor_id' jika ada, jika tidak tetap null)
        $allMurids = Murid::all()->keyBy('murid_id');

        // Loop dan masukkan ke tabel 'leaderboards'
        foreach ($scores as $index => $score) {
            $murid = $allMurids->get($score->murid_id);
            
           Leaderboard::updateOrCreate(
                    ['murid_id' => $score->murid_id], // Kunci pengecekan
                    [
                        'mentor_id' => $murid->mentor_id,
                        'total_poin_semua_game' => $score->total_skor,
                        'ranking_global' => $index + 1, 
                        'ranking_mentor' => 0, 
                    ]
                );
        }
            
    }
}