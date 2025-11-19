<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GameStatic;    
use App\Models\JenisGame;     
use App\Models\TingkatanIqra; 

class GameStaticSeeder extends Seeder
{
    
    public function run(): void
    {
    
        $memoryGame = JenisGame::where('nama_game', 'Memory Card')->first();

    
        $tracingGame = JenisGame::where('nama_game', 'Tracking')->first();
        $labirinGame = JenisGame::where('nama_game', 'Labirin')->first();
        
    
        $semuaTingkatan = TingkatanIqra::all();

    
        if (!$memoryGame) {
            $this->command->error('Data "Memory Card" tidak ditemukan di tabel "jenis_games". Seeder dibatalkan.');
            return;
        }

    
        foreach ($semuaTingkatan as $tingkatan) {
            
    
            GameStatic::updateOrCreate(
                [
                    'tingkatan_id' => $tingkatan->tingkatan_id,
                    'jenis_game_id' => $memoryGame->jenis_game_id,
                ],
                [
                    'nama_game' => 'Memory Card ' . $tingkatan->nama_tingkatan,
                    'data_json' => '{"rows": 3, "columns": 4, "total_pasangan": 6}' // Contoh data JSON
                ]
            );

           
            if ($tracingGame) {
                GameStatic::updateOrCreate(
                    [
                        'tingkatan_id' => $tingkatan->tingkatan_id,
                        'jenis_game_id' => $tracingGame->jenis_game_id,
                    ],
                    [
                        'nama_game' => 'Tracking ' . $tingkatan->nama_tingkatan,
                        'data_json' => '{}'
                    ]
                );
            }

          
            if ($labirinGame) {
                GameStatic::updateOrCreate(
                    [
                        'tingkatan_id' => $tingkatan->tingkatan_id,
                        'jenis_game_id' => $labirinGame->jenis_game_id,
                    ],
                    [
                        'nama_game' => 'Labirin ' . $tingkatan->nama_tingkatan,
                        'data_json' => '{}'
                    ]
                );
            }
        }
        
      
        $this->command->info('Data "game_statics" berhasil di-seed!');
    }
}