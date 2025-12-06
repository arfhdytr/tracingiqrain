<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Murid;
use App\Models\PreferensiPertanyaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class RegisterMuridController extends Controller
{
    /**
     * Show the murid registration form
     */
    public function showRegistrationForm()
    {
        return view('auth.register-murid');
    }

    /**
     * Handle murid registration
     */
    public function register(Request $request)
    {
        // Validasi step 1 (data akun)
        if ($request->step == 1) {
            $validator = Validator::make($request->all(), [
                'username' => ['required', 'string', 'max:50', 'unique:users,username', 'alpha_dash'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'sekolah' => ['nullable', 'string', 'max:100'],
            ], [
                'username.required' => 'Username harus diisi',
                'username.unique' => 'Username sudah digunakan',
                'username.alpha_dash' => 'Username hanya boleh huruf, angka, dash dan underscore',
                'password.required' => 'Password harus diisi',
                'password.min' => 'Password minimal 8 karakter',
                'password.confirmed' => 'Konfirmasi password tidak cocok',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            session([
                'murid_register_data' => [
                    'username' => $request->username,
                    'password' => $request->password,
                    'sekolah' => $request->sekolah,
                ]
            ]);

            return redirect()->route('register.murid.preferensi');
        }

        // Validasi step 2 (pertanyaan preferensi - hanya 1 pertanyaan)
        if ($request->step == 2) {
            $validator = Validator::make($request->all(), [
                'pertanyaan' => ['required', 'string'],
                'jawaban' => ['required', 'string', 'max:255'],
            ], [
                'pertanyaan.required' => 'Pertanyaan harus dipilih',
                'jawaban.required' => 'Jawaban harus diisi',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            // Get data dari session
            $registerData = session('murid_register_data');

            if (!$registerData) {
                return redirect()->route('register.murid')
                    ->with('error', 'Data registrasi tidak ditemukan. Silakan mulai dari awal.');
            }

            DB::beginTransaction();
            try {
                // Create user
                $user = User::create([
                    'username' => $registerData['username'],
                    'password' => Hash::make($registerData['password']),
                ]);

                // Assign role murid
                $user->assignRole('murid');

                // Create murid profile
                $murid = Murid::create([
                    'user_id' => $user->user_id,
                    'sekolah' => $registerData['sekolah'],
                    'preferensi_terisi' => true,
                ]);

                // Create preferensi pertanyaan (hanya 1)
                PreferensiPertanyaan::create([
                    'murid_id' => $murid->murid_id,
                    'pertanyaan' => $request->pertanyaan,
                    'jawaban' => $request->jawaban,
                ]);

                DB::commit();

                // Clear session
                session()->forget('murid_register_data');

                // Redirect ke success page
                return redirect()->route('register.success')
                    ->with('message', 'Registrasi berhasil! Silakan login dengan username dan password Anda.');
            } catch (\Exception $e) {
                DB::rollBack();
                return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
            }
        }

        return back()->with('error', 'Invalid step');
    }

    /**
     * Show preferensi form (step 2)
     */
    public function showPreferensiForm()
    {
        // Check if step 1 data exists in session
        if (!session('murid_register_data')) {
            return redirect()->route('register.murid')
                ->with('error', 'Silakan isi data akun terlebih dahulu.');
        }

        // Pertanyaan preferensi yang tersedia (hanya 1 pertanyaan tentang warna kesukaan)
        $pertanyaanOptions = [
            'Apa warna kesukaanmu?',
        ];

        return view('auth.register-murid-preferensi', compact('pertanyaanOptions'));
    }

    /**
     * Menampilkan form preferensi untuk murid yang sudah login tapi belum setup.
     */
    public function showSetupPreferensiForm()
    {
        $user = Auth::user();
        
        // Pastikan hanya murid dan yang belum mengisi preferensi
        if (!$user->hasRole('murid') || ($user->murid && $user->murid->preferensi_terisi)) {
            return redirect()->route('murid.pilih-iqra');
        }

        $pertanyaanOptions = ['Apa warna kesukaanmu?'];
        
        // Kita kirim variabel actionRoute agar view tahu kemana harus submit
        return view('auth.register-murid-preferensi', [
            'pertanyaanOptions' => $pertanyaanOptions,
            'actionRoute' => route('murid.setup.preferensi.post') // Route baru
        ]);
    }

    /**
     * [BARU] Menyimpan preferensi dari murid yang sudah login.
     */
    public function storeSetupPreferensi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pertanyaan' => ['required', 'string'],
            'jawaban' => ['required', 'string', 'max:255'],
        ], [
            'pertanyaan.required' => 'Pertanyaan harus dipilih',
            'jawaban.required' => 'Jawaban harus diisi',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $user = Auth::user();
            $murid = $user->murid;

            // Simpan Preferensi
            PreferensiPertanyaan::create([
                'murid_id' => $murid->murid_id,
                'pertanyaan' => $request->pertanyaan,
                'jawaban' => $request->jawaban,
            ]);

            // Update status murid
            $murid->update(['preferensi_terisi' => true]);

            DB::commit();

            return redirect()->route('murid.pilih-iqra')
                ->with('success', 'Selamat datang! Akunmu sudah siap digunakan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

}
