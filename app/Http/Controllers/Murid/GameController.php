<?php

namespace App\Http\Controllers\Murid;

use App\Http\Controllers\Controller;
use App\Models\TingkatanIqra;
use App\Models\JenisGame;
use App\Models\HasilGame;
use App\Models\Leaderboard;
use App\Models\Murid;
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
        $jenisGame = JenisGame::where('nama_game', 'Memory Card')->firstOrFail();
        $materiPembelajarans = $tingkatan->materiPembelajarans->take(6); // 6 kombo untuk 12 kartu

        return view('pages.murid.games.memory-card', compact('tingkatan', 'materiPembelajarans', 'jenisGame')); 

    }

    public function tracing($tingkatan_id)
    {
        $tingkatan = TingkatanIqra::with('materiPembelajarans')->findOrFail($tingkatan_id);
        $jenisGame = JenisGame::where('nama_game', 'Tracking')->firstOrFail();

        $materiPembelajarans = $tingkatan->materiPembelajarans;

        return view('pages.murid.games.tracing', compact('tingkatan', 'materiPembelajarans', 'jenisGame'));

    }

    public function tracingStandalone(){
        return view('pages.murid.games.tracing');
    }

    /**
     * Menyimpan hasil (skor) dari game Tracing.
     */
    public function storeTracingScore(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'tingkatan_id' => 'required|exists:tingkatan_iqras,tingkatan_id',
            'skor' => 'required|integer|min:0',
            // 'waktu_pengerjaan' dan 'detail_hasil' bersifat opsional
            'waktu_pengerjaan' => 'nullable|integer|min:0',
            'detail_hasil' => 'nullable|string',
        ]);

        // 2. Dapatkan ID Murid yang sedang login
        $user = Auth::user();
        // Pastikan pengguna terautentikasi dan memiliki relasi Murid
        if (!$user || !$user->murid) {
            return response()->json(['error' => 'Murid tidak terautentikasi.'], 403);
        }
        $murid_id = $user->murid->murid_id;

        // 3. Dapatkan Jenis Game ID untuk 'Tracing'
        $jenisGame = JenisGame::where('nama_game', 'Tracking')->first();

        if (!$jenisGame) {
            // Error jika Jenis Game 'Tracing' belum ada di database
            return response()->json(['error' => 'Jenis game Tracking tidak ditemukan.'], 404);
        }

        // 4. Simpan Hasil Game baru
        try {
            DB::beginTransaction();

            HasilGame::create([
                'murid_id' => $murid_id,
                'jenis_game_id' => $jenisGame->jenis_game_id,
                'tingkatan_id' => $request->tingkatan_id,
                'skor' => $request->skor,
                'waktu_pengerjaan' => $request->waktu_pengerjaan,
                'detail_hasil' => $request->detail_hasil,
            ]);

            // 5. Update Leaderboard
            $this->updateLeaderboardAndRecalculateRankings($murid_id);

            DB::commit();

            // Beri respons sukses (bisa diganti redirect ke halaman lain jika perlu)
            return response()->json([
                'success' => 'Skor game Tracing berhasil disimpan!',
                'skor' => $request->skor
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error saving tracing score: " . $e->getMessage());
            return response()->json(['error' => 'Gagal menyimpan skor. Silakan coba lagi.'], 500);
        }
    }


    public function labirin($tingkatan_id)
    {
        $tingkatan = TingkatanIqra::with('materiPembelajarans')->findOrFail($tingkatan_id);
        $jenisGame = JenisGame::where('nama_game', 'Labirin')->firstOrFail();
        
        // 1. Definisikan 3 map labirin (ukuran 8 baris x 9 kolom)
        $maps = [
            // Map 1
            [
                [0, 1, 1, 1, 0, 0, 0, 0, 1],
                [0, 0, 0, 1, 0, 1, 1, 0, 1],
                [0, 1, 0, 0, 0, 1, 0, 0, 0],
                [0, 1, 1, 0, 1, 1, 0, 1, 0],
                [0, 0, 0, 0, 1, 0, 0, 1, 0],
                [0, 1, 1, 0, 0, 0, 1, 1, 0],
                [0, 0, 1, 0, 1, 0, 0, 0, 1],
                [0, 0, 1, 0, 0, 1, 0, 0, 0],
            ],
            // Map 2
            [
                [0, 0, 0, 1, 1, 1, 0, 0, 1],
                [1, 1, 0, 1, 0, 0, 0, 1, 0],
                [0, 0, 0, 1, 0, 1, 0, 1, 0],
                [0, 1, 0, 0, 0, 1, 0, 0, 0],
                [0, 1, 1, 1, 1, 1, 0, 1, 1],
                [0, 0, 0, 0, 0, 0, 0, 0, 0],
                [1, 1, 0, 1, 1, 0, 1, 0, 0],
                [0, 0, 0, 1, 0, 0, 1, 0, 1],
            ],
            // Map 3
            [
                [0, 1, 0, 0, 0, 1, 1, 0, 1],
                [0, 1, 0, 1, 0, 0, 0, 0, 0],
                [0, 0, 0, 1, 0, 1, 1, 0, 0],
                [0, 1, 0, 1, 0, 1, 0, 0, 0],
                [0, 1, 0, 0, 0, 1, 0, 1, 1],
                [0, 1, 1, 1, 1, 1, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0, 1, 1],
                [1, 1, 1, 0, 1, 0, 0, 0, 0],
            ],
        ];

        // 2. Pilih 1 map secara acak
        $selectedMap = $maps[array_rand($maps)];

        // 3. Definisikan mapping huruf hijaiyah ke nama file
        $hijaiyahMap = [
            'ا' => 'Alif.webp',
            'ب' => 'Ba.webp',
            'ت' => 'Ta.webp',
            'ث' => 'tsa.webp',
            'ج' => 'Jim.webp',
            'ح' => 'Kha.webp',
            'خ' => 'Kho.webp',
            'د' => 'Dal.webp',
            'ذ' => 'Dzal.webp',
            'ر' => 'Ra.webp',
            'ز' => 'Za.webp',
            'س' => 'Sin.webp',
            'ش' => 'Syin.webp',
            'ص' => 'Shod.webp',
            'ض' => 'Dhod.webp',
            'ط' => 'Tho.webp',
            'ظ' => 'Dhlo.webp',
            'ع' => 'Ain.webp',
            'غ' => 'Ghoin.webp',
            'ف' => 'Fa.webp',
            'ق' => 'Qof.webp',
            'ك' => 'Kaf.webp',
            'ل' => 'Lam.webp',
            'م' => 'Mim.webp',
            'ن' => 'Nun.webp',
            'و' => 'Wawu.webp',
            'ي' => 'Ya.webp'
        ];

        // 4. Ambil 4 huruf acak
        $randomLetters = array_rand($hijaiyahMap, 4);

        // 5. Buat array nama file DAN array nama latin
        $targetFiles = [];
        $targetNames = [];
        foreach ($randomLetters as $letter) {
            $fileName = $hijaiyahMap[$letter];
            $targetFiles[] = $fileName;

            $nameOnly = pathinfo($fileName, PATHINFO_FILENAME);
            $capitalizedName = ucfirst($nameOnly);
            $targetNames[] = $capitalizedName;
        }

        // 6. Kirim data ke View Blade
        return view('pages.murid.games.labirin', [
            'tingkatan' => $tingkatan,
            'jenisGame'=>$jenisGame,
            'mapLayout' => $selectedMap,
            'targetLetters' => $targetNames,
            'targetFiles' => $targetFiles,
        ]);
    }


    public function dragDrop($tingkatan_id)
    {
        $tingkatan = TingkatanIqra::findOrFail($tingkatan_id);

        $jenisGame = JenisGame::where('nama_game', 'Kuis Drag & Drop')->first();

        return view('pages.murid.games.drag-drop', compact('tingkatan', 'jenisGame'));
    }

    // ==================================================================
    // FUNGSI SAVE SCORE (UPDATE: Keamanan Max 100 Poin)
    // ==================================================================
    public function saveScore(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'jenis_game_id' => 'required|exists:jenis_games,jenis_game_id',
            'skor' => 'required|integer|min:0',
        ]);

        $murid = Auth::user()->murid;

        // 2. Ambil Info Game untuk Cek Poin Maksimal dari Database
        // Mengambil data JenisGame untuk mengetahui batas maksimal poin (biasanya 100)
        $jenisGame = JenisGame::findOrFail($request->jenis_game_id);
        $poinMaksimal = $jenisGame->poin_maksimal;

        // 3. Logika Pembatasan Skor (Server-Side Security)
        // Jika skor yang dikirim user > poin maksimal database, paksa jadi poin maksimal
        $inputSkor = $request->skor;

        if ($inputSkor > $poinMaksimal) {
            $finalScore = $poinMaksimal;
        } else {
            $finalScore = $inputSkor;
        }

        // 4. Simpan Hasil Game ke Tabel hasil_games
        $hasilGame = HasilGame::create([
            'murid_id' => $murid->murid_id,
            'jenis_game_id' => $request->jenis_game_id,
            'soal_id' => $request->soal_id ?? null,
            'game_static_id' => $request->game_static_id ?? null,
            'skor' => $finalScore,       // Skor yang sudah diamankan
            'total_poin' => $finalScore, // Total poin disamakan dengan skor aman
            'dimainkan_at' => now(),
        ]);

        // 5. Update Leaderboard
        $this->updateLeaderboard($murid->murid_id);

        return response()->json([
            'success' => true,
            'hasil_game_id' => $hasilGame->hasil_game_id,
            'poin_didapat' => $finalScore
        ]);
    }

    // ==================================================================
    // FUNGSI LEADERBOARD (TIDAK BERUBAH)
    // ==================================================================
    private function updateLeaderboard($murid_id)
    {
        $totalPoin = HasilGame::where('murid_id', $murid_id)->sum('total_poin');
        $murid = Murid::find($murid_id);

        $murid = Murid::find($murid_id);

        // Update leaderboard global
        Leaderboard::updateOrCreate(
            [
                'murid_id' => $murid_id,
                'mentor_id' => null,
            ],
            [
                'total_poin_semua_game' => $totalPoin,
            ]
        );

        // Update leaderboard mentor jika ada
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

        $this->recalculateRankings();
    }

    private function recalculateRankings()
    {
        // Global
        $globalLeaderboards = Leaderboard::whereNull('mentor_id')
            ->orderByDesc('total_poin_semua_game')
            ->get();

        foreach ($globalLeaderboards as $index => $leaderboard) {
            $leaderboard->update(['ranking_global' => $index + 1]);
        }

        // Mentor
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
