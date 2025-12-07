<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Murid;
use App\Models\TingkatanIqra;
use App\Models\MateriPembelajaran;
use App\Models\Modul;
use App\Models\JenisGame;
use App\Models\ProgressModul;
use App\Models\HasilGame;
use App\Models\Leaderboard;
use Carbon\Carbon;

class ActivitySeeder extends Seeder
{
    public function run()
    {
        // 1. AMBIL MURID
        $targetUsernames = ['adik1', 'adik2'];
        $murids = Murid::whereHas('user', function ($q) use ($targetUsernames) {
            $q->whereIn('username', $targetUsernames);
        })->get();

        if ($murids->isEmpty()) {
            $this->command->warn('Murid adik1/adik2 tidak ditemukan.');
            return;
        }

        // 2. AMBIL MASTER DATA
        $iqra1 = TingkatanIqra::where('level', 1)->first();
        if (!$iqra1) return;

        $materi = MateriPembelajaran::where('tingkatan_id', $iqra1->tingkatan_id)->first();
        if (!$materi) return;

        // Ambil semua modul dan game
        $allModuls = Modul::where('materi_id', $materi->materi_id)->orderBy('urutan')->get();
        $games = JenisGame::where('tingkatan_id', $iqra1->tingkatan_id)->get();

        // 3. PROSES KEGIATAN
        foreach ($murids as $murid) {
            $username = $murid->user->username;

            // Batas modul yang harus diselesaikan
            $totalModulTarget = ($username === 'adik1') ? 30 : 15;

            // Pointer untuk melacak modul ke berapa yang sedang diproses
            $currentModulIndex = 0;
            $totalPoin = 0;

            // --- LOGIKA FLUKTUASI GRAFIK ---
            // Kita loop mundur dari 6 hari lalu sampai hari ini (Total 7 hari)
            for ($daysAgo = 6; $daysAgo >= 0; $daysAgo--) {

                // Tentukan tanggal untuk hari ini dalam loop
                $currentDate = Carbon::now()->subDays($daysAgo)->setHour(8)->setMinute(0);

                // Tentukan "Jatah Aktivitas" hari ini secara ACAK
                if ($username === 'adik1') {
                    // Adik1 rajin: sehari bisa 2 sampai 6 aktivitas
                    // Kadang 0 (istirahat) biar grafiknya bolong dikit
                    $activitiesToday = rand(0, 10) > 1 ? rand(2, 6) : 0;
                } else {
                    // Adik2 santai: sehari 0 sampai 3 aktivitas
                    $activitiesToday = rand(0, 3);
                }

                // Proses aktivitas sesuai jatah hari ini
                for ($i = 0; $i < $activitiesToday; $i++) {
                    // Stop jika modul sudah habis atau mencapai target user
                    if ($currentModulIndex >= $totalModulTarget) break;
                    if (!isset($allModuls[$currentModulIndex])) break;

                    $modul = $allModuls[$currentModulIndex];

                    // 1. Simpan Progress Modul
                    ProgressModul::firstOrCreate([
                        'murid_id' => $murid->murid_id,
                        'modul_id' => $modul->modul_id,
                    ], [
                        'status' => 'selesai',
                        // Waktu acak antara jam 08:00 - 20:00 di tanggal tersebut
                        'tanggal_mulai' => $currentDate->copy()->addHours(rand(0, 10))->addMinutes(rand(0, 59)),
                        'tanggal_selesai' => $currentDate->copy()->addHours(rand(0, 10))->addMinutes(rand(15, 59)),
                    ]);

                    // 2. Main Game (Acak: 40% kemungkinan main game setelah modul selesai)
                    if (rand(1, 100) <= 40 && $games->isNotEmpty()) {
                        $randomGame = $games->random();

                        $minSkor = ($username === 'adik1') ? 85 : 50;
                        $maxSkor = ($username === 'adik1') ? 100 : 80;
                        $skor = rand($minSkor, $maxSkor);

                        HasilGame::create([
                            'murid_id' => $murid->murid_id,
                            'jenis_game_id' => $randomGame->jenis_game_id,
                            'skor' => $skor,
                            'total_poin' => $skor,
                            // Dimainkan 10-30 menit setelah modul selesai di hari yang SAMA
                            'dimainkan_at' => $currentDate->copy()->addHours(rand(0, 10))->addMinutes(rand(30, 90)),
                        ]);

                        $totalPoin += $skor;
                    }

                    // Pindah ke modul berikutnya
                    $currentModulIndex++;
                }

                // Jika modul sudah habis sebelum hari ini, hentikan loop hari
                if ($currentModulIndex >= $totalModulTarget) break;
            }

            // 4. UPDATE LEADERBOARD
            Leaderboard::updateOrCreate(
                ['murid_id' => $murid->murid_id],
                [
                    'mentor_id' => $murid->mentor_id,
                    'total_poin_semua_game' => $totalPoin,
                    'ranking_global' => 0,
                    'ranking_mentor' => 0,
                ]
            );
        }
    }
}
