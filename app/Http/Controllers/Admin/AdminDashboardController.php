<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Mentor;
use App\Models\Murid;
use App\Models\HasilGame;
use App\Models\SoalDragDrop;
use Illuminate\Http\Request;
use App\Models\DataFeed;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_mentors' => Mentor::count(),
            'pending_mentors' => Mentor::where('status_approval', 'pending')->count(),
            'approved_mentors' => Mentor::where('status_approval', 'approved')->count(),
            'total_murids' => Murid::count(),
            'total_games_played' => HasilGame::count(),
            'total_soal' => SoalDragDrop::count(),
        ];

        $recent_activities = HasilGame::with(['murid.user', 'jenisGame'])
            ->latest('dimainkan_at')
            ->limit(10)
            ->get();

        $dataFeed = new DataFeed();

        return view('pages.admin.dashboard', compact('stats', 'recent_activities', 'dataFeed'));
    }

    public function approval()
    {
        return view('pages.admin.approval.index');
    }

    public function mentors()
    {
        return view('admin.mentors');
    }

    public function murids()
    {
        return view('admin.murids');
    }

    public function activities()
    {
        return view('admin.activities');
    }

    public function content()
    {
        return view('admin.content');
    }

    public function soalManagement()
    {
        return view('admin.soal-management');
    }
}
