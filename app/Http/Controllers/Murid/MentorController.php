<?php

namespace App\Http\Controllers\Murid;

use App\Http\Controllers\Controller;
use App\Models\Mentor;
use App\Models\PermintaanBimbingan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MentorController extends Controller
{
    public function index()
    {
        $murid = Auth::user()->murid;

        // Get all approved mentors
        $mentors = Mentor::with('user')
            ->where('status_approval', 'approved')
            ->get();

        // Get existing request if any
        $pendingRequest = PermintaanBimbingan::where('murid_id', $murid->murid_id)
            ->where('status', 'pending')
            ->first();

        return view('pages.murid.mentor.index', compact('mentors', 'pendingRequest'));
    }

    public function requestBimbingan(Request $request, $mentor_id)
    {
        $murid = Auth::user()->murid;

        // Check if already has mentor
        if ($murid->mentor_id) {
            return response()->json([
                'success' => false,
                'message' => 'Kamu sudah memiliki mentor!'
            ], 400);
        }

        // Check if already has pending request
        $existingRequest = PermintaanBimbingan::where('murid_id', $murid->murid_id)
            ->where('status', 'pending')
            ->first();

        if ($existingRequest) {
            return response()->json([
                'success' => false,
                'message' => 'Kamu masih memiliki permintaan yang menunggu persetujuan!'
            ], 400);
        }

        // Create new request
        PermintaanBimbingan::create([
            'murid_id' => $murid->murid_id,
            'mentor_id' => $mentor_id,
            'status' => 'pending',
            'tanggal_permintaan' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Permintaan bimbingan berhasil dikirim!'
        ]);
    }
}
