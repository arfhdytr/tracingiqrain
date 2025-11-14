<?php

namespace App\Http\Controllers\Murid;

use App\Http\Controllers\Controller;
use App\Models\TingkatanIqra;
use App\Models\MateriPembelajaran;
use App\Models\VideoPembelajaran;
use App\Models\ProgressModul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModulController extends Controller
{
    public function index($tingkatan_id)
    {
        $tingkatan = TingkatanIqra::with(['materiPembelajarans.moduls'])->findOrFail($tingkatan_id);
        $videos = VideoPembelajaran::where('tingkatan_id', $tingkatan_id)->get();

        // Get first materi if exists
        $firstMateri = $tingkatan->materiPembelajarans->first();

        return view('pages.murid.modul.index', compact('tingkatan', 'videos', 'firstMateri'));
    }

    public function video($tingkatan_id)
    {
        $tingkatan = TingkatanIqra::findOrFail($tingkatan_id);
        $videos = VideoPembelajaran::where('tingkatan_id', $tingkatan_id)->get();

        return view('pages.murid.modul.index', compact('tingkatan', 'videos'));
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
        $murid = Auth::user()->murid;

        ProgressModul::updateOrCreate(
            [
                'murid_id' => $murid->murid_id,
                'modul_id' => $request->modul_id,
            ],
            [
                'status' => 'selesai',
                'tanggal_selesai' => now(),
            ]
        );

        return response()->json(['success' => true]);
    }
}
