<?php

namespace App\Http\Controllers\Murid;

use App\Http\Controllers\Controller;
use App\Models\TingkatanIqra;
use App\Models\MateriPembelajaran;
use App\Models\VideoPembelajaran;
use App\Models\ProgressModul;
use App\Models\Modul;
use App\Models\Murid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModulController extends Controller
{
    public function index($tingkatan_id){
        $tingkatan = TingkatanIqra::findOrFail($tingkatan_id);
    
        // Ambil MODULS (huruf) melalui relasi materi
        $hurufs = Modul::whereHas('materiPembelajaran', function($query) use ($tingkatan_id) {
            $query->where('tingkatan_id', $tingkatan_id);
        })
        ->with('materiPembelajaran')
        ->orderBy('urutan')
        ->get();
        
        // Ambil video pembelajaran untuk tingkatan ini
        $videos = VideoPembelajaran::where('tingkatan_id', $tingkatan_id)
            ->orderBy('video_id')
            ->get();
        
        // ✅ INISIALISASI VARIABEL PROGRESS (Default ke 0)
        $progressPercentage = 0;
        $completedModulsCount = 0;
        $totalModuls = $hurufs->count();

        $user = Auth::user();
        
        // Hitung progress hanya jika user login sebagai murid
        if ($user && $user->murid) {
            $murid_id = $user->murid->murid_id;
            
            if ($totalModuls > 0) {
                $modulIds = $hurufs->pluck('modul_id');
                
                $completedModulsCount = ProgressModul::where('murid_id', $murid_id)
                    ->whereIn('modul_id', $modulIds)
                    ->where('status', 'selesai')
                    ->distinct('modul_id')
                    ->count();

                $progressPercentage = round(($completedModulsCount / $totalModuls) * 100);
            }
        }
        
        // ✅ RETURN DI LUAR IF BLOCK - SELALU JALAN!
        return view('pages.murid.modul.index', compact(
            'tingkatan', 
            'hurufs', 
            'videos', 
            'progressPercentage', 
            'completedModulsCount', 
            'totalModuls'
        ));
    }

    public function video($tingkatan_id)
    {
        $tingkatan = TingkatanIqra::findOrFail($tingkatan_id);
        $videos = VideoPembelajaran::where('tingkatan_id', $tingkatan_id)->get();
        
        // ✅ Gunakan nama variabel yang SAMA dengan index()
        $progressPercentage = 0;
        $completedModulsCount = 0; // Bukan completedMaterialsCount
        $totalModuls = 0; // Bukan totalMaterials
        
        // Ambil data huruf juga (supaya konsisten dengan index)
        $hurufs = Modul::whereHas('materiPembelajaran', function($query) use ($tingkatan_id) {
            $query->where('tingkatan_id', $tingkatan_id);
        })
        ->with('materiPembelajaran')
        ->orderBy('urutan')
        ->get();
        
        $totalModuls = $hurufs->count();

        return view('pages.murid.modul.index', compact(
            'tingkatan',
            'hurufs',
            'videos',
            'progressPercentage',
            'completedModulsCount',
            'totalModuls'
        ));
    }

    public function materi($tingkatan_id, $materi_id)
    {
        $tingkatan = TingkatanIqra::findOrFail($tingkatan_id);
        $materi = MateriPembelajaran::with('moduls')->findOrFail($materi_id);
        $allMateris = MateriPembelajaran::where('tingkatan_id', $tingkatan_id)
            ->orderBy('urutan')
            ->get();

        // Get previous and next materi
        $currentIndex = $allMateris->search(function ($item) use ($materi_id) {
            return $item->materi_id == $materi_id;
        });

        $prevMateri = $currentIndex > 0 ? $allMateris[$currentIndex - 1] : null;
        $nextMateri = $currentIndex < $allMateris->count() - 1 ? $allMateris[$currentIndex + 1] : null;

        return response()->json([
            'materi' => $materi,
            'prev' => $prevMateri,
            'next' => $nextMateri,
            'current' => $currentIndex + 1,
            'total' => $allMateris->count()
        ]);
    }

    public function updateProgress(Request $request)
    {
        $request->validate([
        'modul_id' => 'required|integer',  // ✅ Pakai modul_id
        'status' => 'nullable|string|in:belum_dibuka,selesai'
        ]);

        $user = Auth::user();

        if ($user && $user->murid) {
            ProgressModul::updateOrCreate(
                [
                    'murid_id' => $user->murid->murid_id,
                    'modul_id' => $request->modul_id,  // ✅ Kirim modul_id
                ],
                [
                    'status' => $request->status ?? 'selesai',
                    'tanggal_mulai' => now(),
                    'tanggal_selesai' => now(),
                ]
            );
        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
    }

    public function getCompletedModuls()
    {
        $user = Auth::user();
        
        if ($user && $user->murid) {
            $completedModuls = ProgressModul::where('murid_id', $user->murid->murid_id)
                ->where('status', 'selesai')
                ->pluck('modul_id')
                ->toArray();
            
            return response()->json([
                'success' => true,
                'completed_moduls' => $completedModuls
            ]);
        }
        
        return response()->json(['success' => false], 403);
    }
}
