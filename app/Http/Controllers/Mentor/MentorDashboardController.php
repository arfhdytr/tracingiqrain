<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\Murid;
use App\Models\HasilGame;
use App\Models\PermintaanBimbingan;
use App\Models\Leaderboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\ProgressModul;
use App\Models\JenisGame;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MentorDashboardController extends Controller
{
    public function index()
    {
        $mentor = Auth::user()->mentor;

        // 1. Total Murid
        $totalMurids = Murid::where('mentor_id', $mentor->mentor_id)->count();

        // 2. Total Permintaan Pending
        $totalPendingRequests = PermintaanBimbingan::where('mentor_id', $mentor->mentor_id)
            ->where('status', 'pending')
            ->count();

        // 3. Get all murids
        $murids = Murid::where('mentor_id', $mentor->mentor_id)->get();
        $muridIds = $murids->pluck('murid_id');

        // 4. Total Game Dimainkan (7 hari terakhir)
        $totalGamesWeek = HasilGame::whereIn('murid_id', $muridIds)
            ->where('dimainkan_at', '>=', Carbon::now()->subDays(7))
            ->count();

        // 5. Rata-rata Progress Kelas
        $totalModuls = 0;
        $completedModuls = 0;

        foreach ($murids as $murid) {
            $total = ProgressModul::where('murid_id', $murid->murid_id)->count();
            $completed = ProgressModul::where('murid_id', $murid->murid_id)
                ->where('status', 'selesai')
                ->count();

            $totalModuls += $total;
            $completedModuls += $completed;
        }

        $avgProgress = $totalModuls > 0 ? round(($completedModuls / $totalModuls) * 100) : 0;

        // 6. Aktivitas Harian (7 hari terakhir)
        $dailyActivity = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $count = HasilGame::whereIn('murid_id', $muridIds)
                ->whereDate('dimainkan_at', $date)
                ->count();

            $dailyActivity[] = [
                'date' => $date->format('D'),
                'count' => $count
            ];
        }

        // 7. Game Paling Populer
        $popularGames = HasilGame::whereIn('murid_id', $muridIds)
            ->select('jenis_game_id', DB::raw('count(*) as total'))
            ->groupBy('jenis_game_id')
            ->with('jenisGame')
            ->orderBy('total', 'desc')
            ->take(4)
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->jenisGame->nama_game ?? 'Unknown',
                    'total' => $item->total
                ];
            });

        // 8. Murid Terbaru (5 terakhir)
        $recentMurids = Murid::where('mentor_id', $mentor->mentor_id)
            ->with('user')
            ->latest('created_at')
            ->take(5)
            ->get();

        // 9. Top 3 Murid (berdasarkan poin)
        $topMurids = Murid::where('mentor_id', $mentor->mentor_id)
            ->with(['user', 'leaderboards'])
            ->get()
            ->map(function ($murid) use ($mentor) {
                $leaderboard = $murid->leaderboards->where('mentor_id', $mentor->mentor_id)->first();
                return [
                    'murid' => $murid,
                    'poin' => $leaderboard ? $leaderboard->total_poin_semua_game : 0
                ];
            })
            ->sortByDesc('poin')
            ->take(3)
            ->values();

        // 10. Aktivitas Terbaru (10 terakhir)
        $recentActivities = HasilGame::whereIn('murid_id', $muridIds)
            ->with(['murid.user', 'jenisGame'])
            ->latest('dimainkan_at')
            ->take(10)
            ->get();

        // 11. Perbandingan Growth (minggu ini vs minggu lalu)
        $thisWeekGames = HasilGame::whereIn('murid_id', $muridIds)
            ->whereBetween('dimainkan_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->count();

        $lastWeekGames = HasilGame::whereIn('murid_id', $muridIds)
            ->whereBetween('dimainkan_at', [
                Carbon::now()->subWeek()->startOfWeek(),
                Carbon::now()->subWeek()->endOfWeek()
            ])
            ->count();

        $growthPercentage = $lastWeekGames > 0
            ? round((($thisWeekGames - $lastWeekGames) / $lastWeekGames) * 100)
            : 0;

        return view('pages.mentor.dashboard', compact(
            'totalMurids',
            'totalPendingRequests',
            'totalGamesWeek',
            'avgProgress',
            'dailyActivity',
            'popularGames',
            'recentMurids',
            'topMurids',
            'recentActivities',
            'growthPercentage'
        ));
    }

    public function murid()
    {
        return view('pages.mentor.murid.index');
    }

    public function muridCreate()
    {
        return view('pages.mentor.murid.create');
    }

    public function muridEdit(Murid $murid)
    {
        // Pastikan murid adalah murid binaan mentor yang login
        $mentor = Auth::user()->mentor;

        if ($murid->mentor_id !== $mentor->mentor_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('pages.mentor.murid.edit', [
            'murid' => $murid->load(['user', 'preferensiPertanyaan'])
        ]);
    }

    public function downloadTemplate()
    {
        // Buat CSV template (tanpa kolom pertanyaan_preferensi)
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="template_murid.csv"',
        ];

        $columns = ['username', 'password', 'sekolah', 'jawaban_preferensi'];

        $callback = function () use ($columns) {
            $file = fopen('php://output', 'w');

            // Header
            fputcsv($file, $columns);

            // Sample data
            fputcsv($file, [
                'murid123',
                'password123',
                'SD Negeri 1',
                'Merah'
            ]);

            fputcsv($file, [
                'anak_pintar',
                'pass456',
                'SD Negeri 2',
                'Biru'
            ]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function permintaan()
    {
        return view('pages.mentor.permintaan.index');
    }

    public function laporanKelas()
    {
        $mentor = Auth::user()->mentor;

        // Get all murids under this mentor
        $murids = Murid::where('mentor_id', $mentor->mentor_id)
            ->with(['user', 'hasilGames', 'progressModuls'])
            ->get();

        $muridIds = $murids->pluck('murid_id');

        // 1. Game Paling Sering Dimainkan
        $gameStats = HasilGame::whereIn('murid_id', $muridIds)
            ->select('jenis_game_id', DB::raw('count(*) as total'))
            ->groupBy('jenis_game_id')
            ->with('jenisGame')
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->jenisGame->nama_game ?? 'Unknown',
                    'total' => $item->total
                ];
            });

        // 2. Progress Harian Bulan Ini (30 hari terakhir)
        $dailyProgress = [];
        $startDate = Carbon::now()->subDays(29)->startOfDay();

        for ($i = 0; $i < 30; $i++) {
            $date = $startDate->copy()->addDays($i);
            $count = HasilGame::whereIn('murid_id', $muridIds)
                ->whereDate('dimainkan_at', $date)
                ->count();

            $dailyProgress[] = [
                'date' => $date->format('d M'),
                'count' => $count
            ];
        }

        // 3. Rata-rata Progress (persentase modul selesai)
        $totalModuls = 0;
        $completedModuls = 0;

        foreach ($murids as $murid) {
            $total = $murid->progressModuls->count();
            $completed = $murid->progressModuls->where('status', 'selesai')->count();

            $totalModuls += $total;
            $completedModuls += $completed;
        }

        $avgProgress = $totalModuls > 0 ? round(($completedModuls / $totalModuls) * 100) : 0;

        // 4. Murid Paling Aktif (berdasarkan jumlah game dimainkan)
        $mostActiveMurid = HasilGame::whereIn('murid_id', $muridIds)
            ->select('murid_id', DB::raw('count(*) as total_games'))
            ->groupBy('murid_id')
            ->orderBy('total_games', 'desc')
            ->first();

        $mostActiveMuridName = 'Belum ada';
        if ($mostActiveMurid) {
            $murid = Murid::find($mostActiveMurid->murid_id);
            $mostActiveMuridName = $murid->user->username ?? 'Unknown';
        }

        // 5. Level/Tingkatan Paling Populer (berdasarkan progress modul)
        $popularLevel = ProgressModul::whereIn('murid_id', $muridIds)
            ->select('modul_id')
            ->groupBy('modul_id')
            ->orderByRaw('COUNT(*) DESC')
            ->first();

        $popularLevelName = 'Iqra 1'; // Default
        if ($popularLevel) {
            $modul = \App\Models\Modul::find($popularLevel->modul_id);
            if ($modul && $modul->materiPembelajaran && $modul->materiPembelajaran->tingkatanIqra) {
                $popularLevelName = $modul->materiPembelajaran->tingkatanIqra->nama_tingkatan;
            }
        }

        // 6. Total Waktu Belajar (estimasi: setiap game = 5 menit, setiap modul = 10 menit)
        $totalGames = HasilGame::whereIn('murid_id', $muridIds)->count();
        $totalModulProgress = ProgressModul::whereIn('murid_id', $muridIds)
            ->where('status', 'selesai')
            ->count();

        $totalMinutes = ($totalGames * 5) + ($totalModulProgress * 10);
        $totalHours = round($totalMinutes / 60, 1);

        // 7. Total Murid
        $totalMurids = $murids->count();

        // 8. Total Game Dimainkan
        $totalGamesPlayed = HasilGame::whereIn('murid_id', $muridIds)->count();

        return view('pages.mentor.laporan-kelas.index', compact(
            'gameStats',
            'dailyProgress',
            'avgProgress',
            'mostActiveMuridName',
            'popularLevelName',
            'totalHours',
            'totalMurids',
            'totalGamesPlayed'
        ));
    }

    public function laporanMurid()
    {
        return view('pages.mentor.laporan-murid.index');
    }

    public function laporanMuridDetail(Murid $murid)
    {
        // Pastikan murid adalah murid binaan mentor yang login
        $mentor = Auth::user()->mentor;

        if ($murid->mentor_id !== $mentor->mentor_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('pages.mentor.laporan-murid.detail', [
            'murid' => $murid->load([
                'user',
                'leaderboards',
                'hasilGames.jenisGame',
                'progressModuls.modul.materiPembelajaran.tingkatanIqra'
            ])
        ]);
    }
}
