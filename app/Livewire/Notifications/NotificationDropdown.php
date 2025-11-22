<?php
// app/Livewire/Notifications/NotificationDropdown.php

namespace App\Livewire\Notifications;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\HasilGame;
use App\Models\ProgressModul;
use App\Models\PermintaanBimbingan;
use App\Models\Murid;
use App\Models\Mentor;
use Carbon\Carbon;

class NotificationDropdown extends Component
{
    public $notifications = [];
    public $unreadCount = 0;
    public $isLoaded = false; // Flag untuk cek apakah data sudah di-load

    public function mount()
    {
        // Hanya load unread count di mount (ringan)
        $this->loadUnreadCount();
        // Jangan load notifikasi lengkap dulu
    }

    // Method ini dipanggil saat dropdown dibuka
    public function loadNotifications()
    {
        // Cek apakah sudah pernah di-load
        if ($this->isLoaded) {
            return;
        }

        $user = Auth::user();

        if ($user->hasRole('mentor')) {
            $this->loadMentorNotifications();
        } elseif ($user->hasRole('admin')) {
            $this->loadAdminNotifications();
        }

        $this->isLoaded = true;
    }

    protected function loadMentorNotifications()
    {
        $mentor = Auth::user()->mentor;
        $muridIds = $mentor->murids->pluck('murid_id');

        $notifications = collect();

        // 1. Permintaan Bimbingan Baru (Pending)
        $permintaanBaru = PermintaanBimbingan::where('mentor_id', $mentor->mentor_id)
            ->where('status', 'pending')
            ->latest('tanggal_permintaan')
            ->take(2)
            ->get()
            ->map(function ($permintaan) {
                return [
                    'type' => 'permintaan',
                    'icon' => '👋',
                    'title' => 'Permintaan Bimbingan Baru',
                    'message' => ($permintaan->murid->user->username ?? 'Seorang murid') . ' ingin bergabung ke kelas Anda',
                    'time' => $permintaan->tanggal_permintaan,
                    'url' => route('mentor.permintaan.index'),
                ];
            });

        $notifications = $notifications->merge($permintaanBaru);

        // 2. Murid Menyelesaikan Modul
        $modulSelesai = ProgressModul::whereIn('murid_id', $muridIds)
            ->where('status', 'selesai')
            ->whereNotNull('tanggal_selesai')
            ->latest('tanggal_selesai')
            ->take(2)
            ->get()
            ->map(function ($progress) {
                $muridName = $progress->murid->user->username ?? 'Murid';
                $modulName = $progress->modul->judul_modul ?? 'modul';

                return [
                    'type' => 'modul_selesai',
                    'icon' => '🎓',
                    'title' => 'Modul Diselesaikan',
                    'message' => $muridName . ' telah menyelesaikan ' . $modulName,
                    'time' => $progress->tanggal_selesai,
                    'url' => route('mentor.laporan-murid.detail', $progress->murid_id),
                ];
            });

        $notifications = $notifications->merge($modulSelesai);

        // 3. Pencapaian Game Tinggi
        $gameTinggi = HasilGame::whereIn('murid_id', $muridIds)
            ->where('skor', '>=', 90)
            ->latest('dimainkan_at')
            ->take(2)
            ->get()
            ->map(function ($hasil) {
                $muridName = $hasil->murid->user->username ?? 'Murid';
                $gameName = $hasil->jenisGame->nama_game ?? 'game';

                return [
                    'type' => 'game_tinggi',
                    'icon' => '🏆',
                    'title' => 'Skor Tinggi!',
                    'message' => $muridName . ' mendapat skor ' . $hasil->skor . ' di ' . $gameName,
                    'time' => $hasil->dimainkan_at,
                    'url' => route('mentor.laporan-murid.detail', $hasil->murid_id),
                ];
            });

        $notifications = $notifications->merge($gameTinggi);

        // 4. Murid Baru Bergabung
        $muridBaru = Murid::where('mentor_id', $mentor->mentor_id)
            ->latest('created_at')
            ->take(1)
            ->get()
            ->map(function ($murid) {
                return [
                    'type' => 'murid_baru',
                    'icon' => '🎉',
                    'title' => 'Murid Baru Bergabung',
                    'message' => ($murid->user->username ?? 'Seorang murid') . ' telah bergabung ke kelas Anda',
                    'time' => $murid->created_at,
                    'url' => route('mentor.murid.index'),
                ];
            });

        $notifications = $notifications->merge($muridBaru);

        // Sort by time descending and take 3
        $this->notifications = $notifications
            ->sortByDesc('time')
            ->take(3)
            ->values()
            ->toArray();
    }

    protected function loadAdminNotifications()
    {
        $notifications = collect();

        // 1. Mentor Menunggu Approval
        $mentorPending = Mentor::where('status_approval', 'pending')
            ->latest('created_at')
            ->take(2)
            ->get()
            ->map(function ($mentor) {
                return [
                    'type' => 'mentor_pending',
                    'icon' => '👨‍🏫',
                    'title' => 'Pendaftaran Mentor Baru',
                    'message' => ($mentor->nama_lengkap ?? 'Seorang mentor') . ' menunggu persetujuan',
                    'time' => $mentor->created_at,
                    'url' => route('admin.mentor.index'),
                ];
            });

        $notifications = $notifications->merge($mentorPending);

        // 2. Aktivitas Game Hari Ini (Global)
        $totalGamesToday = HasilGame::whereDate('dimainkan_at', today())->count();

        if ($totalGamesToday > 0) {
            $notifications->push([
                'type' => 'game_today',
                'icon' => '📊',
                'title' => 'Aktivitas Hari Ini',
                'message' => $totalGamesToday . ' game dimainkan oleh murid',
                'time' => now(),
                'url' => route('admin.dashboard'),
            ]);
        }

        // 3. Murid Baru Terdaftar (Global)
        $muridBaru = Murid::latest('created_at')
            ->take(1)
            ->get()
            ->map(function ($murid) {
                return [
                    'type' => 'murid_baru_global',
                    'icon' => '🎓',
                    'title' => 'Murid Baru Terdaftar',
                    'message' => ($murid->user->username ?? 'Seorang murid') . ' telah mendaftar',
                    'time' => $murid->created_at,
                    'url' => route('admin.murid.index'),
                ];
            });

        $notifications = $notifications->merge($muridBaru);

        // Sort by time descending and take 3
        $this->notifications = $notifications
            ->sortByDesc('time')
            ->take(3)
            ->values()
            ->toArray();
    }

    // Method terpisah untuk load unread count saja (ringan)
    protected function loadUnreadCount()
    {
        $user = Auth::user();
        $lastCheck = session('last_notification_check', now()->subHours(24));

        if ($user->hasRole('mentor')) {
            $mentor = $user->mentor;
            $muridIds = $mentor->murids->pluck('murid_id');

            $count = 0;

            // Permintaan pending
            $count += PermintaanBimbingan::where('mentor_id', $mentor->mentor_id)
                ->where('status', 'pending')
                ->where('tanggal_permintaan', '>', $lastCheck)
                ->count();

            // Modul selesai
            $count += ProgressModul::whereIn('murid_id', $muridIds)
                ->where('status', 'selesai')
                ->where('tanggal_selesai', '>', $lastCheck)
                ->count();

            // Game skor tinggi
            $count += HasilGame::whereIn('murid_id', $muridIds)
                ->where('skor', '>=', 90)
                ->where('dimainkan_at', '>', $lastCheck)
                ->count();

            $this->unreadCount = min($count, 9);
        } elseif ($user->hasRole('admin')) {
            $count = 0;

            // Mentor pending
            $count += Mentor::where('status_approval', 'pending')
                ->where('created_at', '>', $lastCheck)
                ->count();

            $this->unreadCount = min($count, 9);
        }
    }

    public function markAsRead()
    {
        session(['last_notification_check' => now()]);
        $this->unreadCount = 0;
    }

    // Method untuk refresh notifikasi
    public function refreshNotifications()
    {
        $this->isLoaded = false;
        $this->loadNotifications();
        $this->loadUnreadCount();
    }

    public function render()
    {
        return view('livewire.notifications.notification-dropdown');
    }
}
