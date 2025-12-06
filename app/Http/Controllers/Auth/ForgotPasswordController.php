<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    // STEP 1: Tampilkan Form Username
    public function showUsernameForm()
    {
        return view('auth.forgot-password-murid-username');
    }

    // STEP 2: Identifikasi User & Role
    public function checkUsername(Request $request)
    {
        $request->validate(['username' => 'required|exists:users,username']);

        $user = User::where('username', $request->username)->first();

        // Simpan username di session untuk langkah selanjutnya
        session(['reset_username' => $user->username]);

        // Logika Percabangan Role
        if ($user->hasRole('murid')) {
            return redirect()->route('password.murid.question');
        } elseif ($user->hasRole('mentor')) {
            return redirect()->route('password.mentor.email');
        } else {
            return back()->with('error', 'Role tidak diizinkan untuk reset password mandiri.');
        }
    }

    /*
    |--------------------------------------------------------------------------
    | ALUR MURID (Security Question)
    |--------------------------------------------------------------------------
    */

    public function showMuridQuestion()
    {
        $username = session('reset_username');
        if (!$username) return redirect()->route('password.request');

        $user = User::where('username', $username)->first();
        // Mengambil pertanyaan dari relasi PreferensiPertanyaan
        $preferensi = $user->murid->preferensiPertanyaan;

        if (!$preferensi) {
            return redirect()->route('login')->with('error', 'Anda belum mengatur pertanyaan keamanan.');
        }

        return view('auth.forgot-password-murid-questions', [
            'pertanyaan' => $preferensi->pertanyaan //
        ]);
    }

    public function verifyMuridAnswer(Request $request)
    {
        $username = session('reset_username');
        $user = User::where('username', $username)->first();
        
        // Mengambil jawaban hash dari DB
        $preferensi = $user->murid->preferensiPertanyaan;

        // Verifikasi jawaban (Case Insensitive sesuai logika di MODEL (1).txt atau manual check)
        if (strtolower($request->jawaban) === strtolower($preferensi->jawaban)) {
            // Jika benar, beri akses reset
            session(['can_reset_password' => true]);
            return redirect()->route('password.reset.form');
        }

        return back()->with('error', 'Jawaban salah, coba lagi.');
    }

    /*
    |--------------------------------------------------------------------------
    | ALUR MENTOR (Email Verification)
    |--------------------------------------------------------------------------
    */

    public function showMentorEmailForm()
    {
        if (!session('reset_username')) return redirect()->route('password.request');
        return view('auth.forgot-password-mentor-email');
    }


    public function verifyMentorEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        
        $username = session('reset_username');
        $user = User::where('username', $username)->first();

        if (!$user || !$user->mentor) {
            return back()->with('error', 'Data akun Mentor tidak ditemukan atau tidak lengkap. Silakan hubungi admin.');
        }
        
        $mentorEmail = $user->mentor->email;

        if ($mentorEmail !== $request->email) {
            return back()->with('error', 'Alamat email tidak cocok dengan data pendaftaran Mentor.');
        }
        
        try {
            $token = Password::broker()->createToken($user);
            $user->sendPasswordResetNotification($token);

            return back()->with('status', 'Tautan reset password telah dikirim ke email: ' . $mentorEmail);
        
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim email reset password Mentor: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengirim email reset password. Silakan coba lagi.'); 
        }
    }

    public function showResetForm(Request $request)
    {
        $isMuridApproved = session('can_reset_password');
        $token = $request->route('token');

        if (!$isMuridApproved && !$token) {
            return redirect()->route('login');
        }

        if ($token) {
            return view('auth.reset-password', [
                'token' => $token, 
                'email' => $request->email 
            ]);
        }

        if ($isMuridApproved) {
            return view('auth.forgot-password-murid-reset', [
                'username' => session('reset_username'),
                'token' => null, 
                'email' => null, 
            ]);
        }
        
        return redirect()->route('login')->with('error', 'Akses reset password tidak valid.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        // KASUS 1: MURID 
        if (session('can_reset_password')) {
            $username = session('reset_username');
            $user = \App\Models\User::where('username', $username)->first();

            if ($user) {
                $user->forceFill([
                    'password' => Hash::make($request->password)
                ])->save();

                session()->forget(['reset_username', 'can_reset_password']);

                return redirect()->route('login')->with('status', 'Password berhasil diperbarui. Silakan login kembali.');
            }
        }

        // KASUS 2: MENTOR 

        // 1. Cari data Mentor berdasarkan email inputan
        // Kita cari di tabel 'mentors', BUKAN 'users' agar tidak error column not found
        $mentor = \App\Models\Mentor::where('email', $request->email)->first();

        // 2. Jika mentor tidak ditemukan atau tidak punya relasi user, kembalikan error
        if (!$mentor || !$mentor->user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan di data Mentor.']);
        }

        $user = $mentor->user;

        // 3. Cek apakah Token Valid?
        // Fungsi ini aman karena User.php sudah di-override getEmailForPasswordReset-nya
        if (!Password::broker()->tokenExists($user, $request->token)) {
            return back()->withErrors(['email' => 'Token password tidak valid atau sudah kadaluarsa.']);
        }

        // 4. Update Password User secara Manual
        $user->forceFill([
            'password' => Hash::make($request->password),
        ])->save();

        // 5. Hapus Token dari database (agar tidak bisa dipakai ulang)
        Password::broker()->deleteToken($user);

        // 6. Sukses & Redirect
        return redirect()->route('login')->with('success', 'Password berhasil diperbarui. Silakan login kembali.');
    }
}