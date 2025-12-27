<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Mentor;
use App\Models\Murid;
use App\Models\PreferensiPertanyaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        //CARI USER BERDASARKAN USERNAME
        $user = User::where('username', $request->username)->first();

        //JIKA USER TIDAK DITEMUKAN
        if (!$user) {
            return back()
                ->withErrors(['username' => 'Username tidak ditemukan.'])
                ->withInput();
        }

        //JIKA PASSWORD SALAH
        if (!Hash::check($request->password, $user->password)) {
            return back()
                ->withErrors(['password' => 'Password yang Anda masukkan salah.'])
                ->withInput();
        }

        //JIKA LOLOS, LAKUKAN LOGIN MANUAL
        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        // Cek Status Mentor (Logika Asli Anda)
        if ($user->hasRole('mentor') && $user->mentor && $user->mentor->status_approval !== 'approved') {
            
            return redirect()->route('register.mentor.pending'); 
        }

        return redirect()->intended(route('dashboard'));
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function showRegisterStep2(Request $request)
    {
        $role = $request->get('role');
        if (!in_array($role, ['mentor', 'murid'])) {
            return redirect()->route('register')->with('error', 'Role tidak valid');
        }

        return view('auth.register-step2', compact('role'));
    }

    public function register(Request $request)
    {
        try {
            DB::beginTransaction();

            // Validation rules based on role
            $rules = [
                'role' => 'required|string|in:mentor,murid',
                'username' => 'required|string|max:50|unique:users',
                'password' => 'required|string|min:6|confirmed',
                'nama_lengkap' => 'required|string|max:100',
            ];

            if ($request->role === 'mentor') {
                $rules['email'] = 'required|email|unique:mentors,email';
                $rules['no_wa'] = 'required|string|max:20';
            } else {
                $rules['sekolah'] = 'required|string|max:100';
                $rules['warna_kesukaan'] = 'required|string|max:50';
            }

            $request->validate($rules);

            // Create User
            $user = User::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
            ]);

            // Assign role
            $user->assignRole($request->role);

            if ($request->role === 'mentor') {
                // Create Mentor profile
                Mentor::create([
                    'user_id' => $user->user_id,
                    'nama_lengkap' => $request->nama_lengkap,
                    'email' => $request->email,
                    'no_wa' => $request->no_wa,
                    'status_approval' => 'pending',
                ]);

                DB::commit();
                return redirect()->route('auth.register-success')->with([
                    'type' => 'mentor',
                    'message' => 'Registrasi berhasil! Menunggu persetujuan admin.'
                ]);
            } else {
                // Create Murid profile
                $murid = Murid::create([
                    'user_id' => $user->user_id,
                    'sekolah' => $request->sekolah,
                    'preferensi_terisi' => true,
                ]);

                // Create preference questions
                PreferensiPertanyaan::create([
                    'murid_id' => $murid->murid_id,
                    'pertanyaan_1' => 'Apa warna kesukaan kamu?',
                    'jawaban_1' => $request->warna_kesukaan,
                    'pertanyaan_2' => 'Siapa nama hewan peliharaan kamu?',
                    'jawaban_2' => $request->nama_hewan ?? '',
                    'pertanyaan_3' => 'Di kota mana kamu lahir?',
                    'jawaban_3' => $request->kota_lahir ?? '',
                ]);

                DB::commit();

                // Auto login for murid
                Auth::login($user);
                return redirect()->route('auth.register-success')->with([
                    'type' => 'murid',
                    'message' => 'Selamat datang! Akun berhasil dibuat.'
                ]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    public function showRegisterSuccess()
    {
        return view('auth.register-success');
    }

    public function showPendingApproval()
    {
        $user = Auth::user();

        if (!$user || !$user->hasRole('mentor')) {
            return redirect()->route('login');
        }

        return view('auth.register-mentor-pending');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing');
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function handleForgotPassword(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'user_type' => 'required|string|in:mentor,murid',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user || !$user->hasRole($request->user_type)) {
            return back()->withErrors(['username' => 'Username tidak ditemukan untuk role ' . $request->user_type]);
        }

        if ($request->user_type === 'mentor') {
            // Untuk mentor, kirim email reset
            // Implementasi email reset (gunakan Laravel default atau custom)
            return back()->with('status', 'Link reset password telah dikirim ke email Anda.');
        } else {
            // Untuk murid, redirect ke security questions
            return redirect()->route('auth.security-questions', ['user_id' => $user->user_id]);
        }
    }

    public function showSecurityQuestions($userId)
    {
        $user = User::find($userId);
        if (!$user || !$user->hasRole('murid')) {
            return redirect()->route('login');
        }

        $murid = $user->murid;
        $preferensi = $murid->preferensiPertanyaan;

        if (!$preferensi) {
            return redirect()->route('login')->with('error', 'Pertanyaan keamanan tidak ditemukan');
        }

        return view('auth.security-questions', compact('user', 'preferensi'));
    }

    public function verifySecurityQuestions(Request $request, $userId)
    {
        $request->validate([
            'jawaban_1' => 'required|string',
            'jawaban_2' => 'nullable|string',
            'jawaban_3' => 'nullable|string',
        ]);

        $user = User::find($userId);
        if (!$user || !$user->hasRole('murid')) {
            return redirect()->route('login');
        }

        $preferensi = $user->murid->preferensiPertanyaan;

        // Check answers
        $correctAnswers = 0;
        if (strtolower(trim($request->jawaban_1)) === strtolower(trim($preferensi->jawaban_1))) {
            $correctAnswers++;
        }
        if ($request->jawaban_2 && strtolower(trim($request->jawaban_2)) === strtolower(trim($preferensi->jawaban_2))) {
            $correctAnswers++;
        }
        if ($request->jawaban_3 && strtolower(trim($request->jawaban_3)) === strtolower(trim($preferensi->jawaban_3))) {
            $correctAnswers++;
        }

        if ($correctAnswers >= 1) { // Minimal 1 jawaban benar (sesuai feedback klien: 1 pertanyaan saja)
            return redirect()->route('auth.reset-password', ['user_id' => $userId]);
        } else {
            return back()->withErrors(['error' => 'Jawaban tidak sesuai. Silakan coba lagi.']);
        }
    }

    public function showResetPassword($userId)
    {
        $user = User::find($userId);
        if (!$user) {
            return redirect()->route('login');
        }

        return view('auth.reset-password', compact('user'));
    }

    public function resetPassword(Request $request, $userId)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::find($userId);
        if (!$user) {
            return redirect()->route('login');
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        Auth::login($user);
        return redirect()->route('dashboard')->with('success', 'Password berhasil diubah!');
    }
}