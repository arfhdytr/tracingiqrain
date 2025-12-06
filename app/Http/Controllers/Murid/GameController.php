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
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

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

        $murid = Auth::user()->murid;

        $sessionGame = HasilGame::create([
            'murid_id' => $murid->murid_id,
            'jenis_game_id' => $jenisGame->jenis_game_id,
            'skor' => 0,
            'total_poin' => 0,
            'dimainkan_at' => now(),
        ]);

        return view('pages.murid.games.memory-card', compact('tingkatan', 'materiPembelajarans', 'jenisGame', 'sessionGame'));
    }

    public function tracing($tingkatan_id)
    {
        $tingkatan = TingkatanIqra::with('materiPembelajarans')->findOrFail($tingkatan_id);
        $jenisGame = JenisGame::where('nama_game', 'Tracing')->firstOrFail();
        $murid = Auth::user()->murid;

        $sessionGame = HasilGame::create([
            'murid_id' => $murid->murid_id,
            'jenis_game_id' => $jenisGame->jenis_game_id,
            'skor' => 0,
            'total_poin' => 0,
            'dimainkan_at' => now(),
        ]);

        $materiPembelajarans = $tingkatan->materiPembelajarans;

        return view('pages.murid.games.tracing', compact('tingkatan', 'materiPembelajarans', 'jenisGame', 'sessionGame'));
    }

    public function tracingStandalone()
    {
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
        $jenisGame = JenisGame::where('nama_game', 'Tracing')->first();

        if (!$jenisGame) {
            // Error jika Jenis Game 'Tracing' belum ada di database
            return response()->json(['error' => 'Jenis game Tracing tidak ditemukan.'], 404);
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
            return response()->json(['error' => 'Gagal menyimpan skor. Silakan coba lagi.'], 500);
        }
    }


    public function labirin($tingkatan_id)
    {
        $tingkatan = TingkatanIqra::with('materiPembelajarans')->findOrFail($tingkatan_id);
        $jenisGame = JenisGame::where('nama_game', 'Labirin')->firstOrFail();
        $murid = Auth::user()->murid;

        $sessionGame = HasilGame::create([
            'murid_id' => $murid->murid_id,
            'jenis_game_id' => $jenisGame->jenis_game_id,
            'skor' => 0,  // Skor awal 0
            'total_poin' => 0,  // Poin awal 0
            'dimainkan_at' => now(),
        ]);

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
            'ث' => 'Tsa.webp',
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
            'jenisGame' => $jenisGame,
            'mapLayout' => $selectedMap,
            'targetLetters' => $targetNames,
            'targetFiles' => $targetFiles,
            'currentSessionId' => $sessionGame->hasil_game_id,
            'allMaps' => $maps,
        ]);
    }


    public function dragDrop($tingkatan_id): View
    {
        $tingkatan = TingkatanIqra::findOrFail($tingkatan_id);

        $jenisGame = JenisGame::where('nama_game', 'Kuis Drag & Drop')->first();

        $hijaiyahData = [
            ['file' => 'Alif', 'latin' => 'Alif'],
            ['file' => 'Ba', 'latin' => 'Ba'],
            ['file' => 'Ta', 'latin' => 'Ta'],
            ['file' => 'Tsa', 'latin' => 'Tsa'],
            ['file' => 'Jim', 'latin' => 'Jim'],
            ['file' => 'Kha', 'latin' => 'Kha'],
            ['file' => 'Kho', 'latin' => 'Kho'],
            ['file' => 'Dal', 'latin' => 'Dal'],
            ['file' => 'Dzal', 'latin' => 'Dzal'],
            ['file' => 'Ra', 'latin' => 'Ra'],
            ['file' => 'Za', 'latin' => 'Zayn'],
            ['file' => 'Sin', 'latin' => 'Sin'],
            ['file' => 'Syin', 'latin' => 'Syin'],
            ['file' => 'Shod', 'latin' => 'Shod'],
            ['file' => 'Dhod', 'latin' => 'Dhod'],
            ['file' => 'Tho', 'latin' => 'Tho'],
            ['file' => 'Dhlo', 'latin' => 'Dhlo'],
            ['file' => 'Ain', 'latin' => 'Ain'],
            ['file' => 'Ghoin', 'latin' => 'Ghoin'],
            ['file' => 'Fa', 'latin' => 'Fa'],
            ['file' => 'Qof', 'latin' => 'Qof'],
            ['file' => 'Kaf', 'latin' => 'Kaf'],
            ['file' => 'Lam', 'latin' => 'Lam'],
            ['file' => 'Mim', 'latin' => 'Mim'],
            ['file' => 'Nun', 'latin' => 'Nun'],
            ['file' => 'Wawu', 'latin' => 'Wawu'],
            ['file' => 'Ha', 'latin' => 'Ha'],
            ['file' => 'Lamalif', 'latin' => 'Lam Alif'],
            ['file' => 'Hamzah', 'latin' => 'Hamzah'],
            ['file' => 'Ya', 'latin' => 'Ya'],
        ];


        $murid = Auth::user()->murid;

        $sessionGame = HasilGame::create([
            'murid_id' => $murid->murid_id,
            'jenis_game_id' => $jenisGame->jenis_game_id,
            'skor' => 0,
            'total_poin' => 0,
            'dimainkan_at' => now(),
        ]);

        return view('pages.murid.games.drag-drop', compact('tingkatan', 'jenisGame', 'hijaiyahData', 'sessionGame'));
    }


    // ==== Untuk menyimpan nilai  ===
    public function saveScore(Request $request)
    {
        $request->validate([
            // Kita butuh ID Sesi untuk update, bukan create baru
            'hasil_game_id' => 'required|exists:hasil_games,hasil_game_id',
            'skor' => 'required|integer|min:0',
        ]);

        try {
            DB::beginTransaction();

            // 1. Cari data sesi yang dibuat saat masuk halaman tadi
            $hasilGame = HasilGame::findOrFail($request->hasil_game_id);

            // 2. Pastikan yang update adalah pemilik data (Security Check)
            if ($hasilGame->murid_id != Auth::user()->murid->murid_id) {
                return response()->json(['success' => false, 'message' => 'Unauthorized Access'], 403);
            }

            // 3. Hitung Poin (Capped Max Poin)
            $poinMaksimal = $hasilGame->jenisGame->poin_maksimal ?? 100;
            $finalScore = min($request->skor, $poinMaksimal);

            // 4. LAKUKAN UPDATE
            // Saat di-update, Model Observer (booted/saved) akan otomatis jalan lagi
            // untuk merevisi Leaderboard. Jadi Leaderboard aman.
            $hasilGame->update([
                'skor' => $finalScore, // Gunakan skor yang sudah dicap
                'total_poin' => $finalScore,
                // dimainkan_at tidak perlu diubah karena itu waktu mulai main
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'hasil_game_id' => $hasilGame->hasil_game_id,
                'poin_didapat' => $finalScore,
                'message' => 'Skor berhasil diperbarui!'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saveScore: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal update: ' . $e->getMessage()
            ], 500);
        }
    }
    // ==================================================================
    // FUNGSI LEADERBOARD (TIDAK BERUBAH)
    // ==================================================================
    private function updateLeaderboardAndRankings($murid_id)
    {
        //Hitung Total Skor Baru si Murid
        $totalPoin = HasilGame::where('murid_id', $murid_id)->sum('total_poin');
        $murid = Murid::find($murid_id);

        // Update Tabel Leaderboard (Satu Baris Saja!)
        // Kita pastikan mentor_id-nya sinkron dengan data murid saat ini.
        Leaderboard::updateOrCreate(
            ['murid_id' => $murid_id], // Cari berdasarkan murid
            [
                'mentor_id' => $murid->mentor_id,
                'total_poin_semua_game' => $totalPoin,
            ]
        );

        // 3. Hitung Ulang Ranking GLOBAL (Semua Murid)
        // Urutkan semua data berdasarkan skor tertinggi
        $allLeaderboards = Leaderboard::orderByDesc('total_poin_semua_game')->get();
        foreach ($allLeaderboards as $index => $lb) {
            // Kita update ranking_global langsung (1, 2, 3...)
            // Jangan lupa: where('id') biar efisien
            Leaderboard::where('leaderboard_id', $lb->leaderboard_id)
                ->update(['ranking_global' => $index + 1]);
        }

        // 4. Hitung Ulang Ranking MENTOR (Per Group)
        // Ambil daftar semua mentor yang ada di tabel leaderboard
        $mentorIds = Leaderboard::whereNotNull('mentor_id')
            ->distinct()
            ->pluck('mentor_id');

        foreach ($mentorIds as $mentorId) {
            // Ambil murid-murid milik mentor ini, urutkan skor
            $mentorGroup = Leaderboard::where('mentor_id', $mentorId)
                ->orderByDesc('total_poin_semua_game')
                ->get();

            foreach ($mentorGroup as $index => $lb) {
                Leaderboard::updateOrCreate(
                    ['leaderboard_id' => $lb->leaderboard_id],
                    ['ranking_mentor' => $index + 1]
                );
            }
        }
    }
}
