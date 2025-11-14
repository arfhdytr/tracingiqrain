<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;

use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;

/*
|--------------------------------------------------------------------------
| FortifyServiceProvider
|--------------------------------------------------------------------------
|
| Service provider utama untuk melakukan kustomisasi pada alur
| autentikasi bawaan Laravel Fortify.
|
*/

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Mendaftarkan service aplikasi.
     *
     * Di sinilah kita "memberi tahu" Fortify untuk menggunakan
     * class kustom kita saat menangani response setelah login.
     */
    public function register(): void
    {
        // Mengikat interface LoginResponseContract ke implementasi kustom
        // (CustomLoginResponse) yang didefinisikan di bagian bawah file ini.
        $this->app->singleton(
            LoginResponseContract::class,
            CustomLoginResponse::class
        );
    }

    /**
     * Bootstrap service aplikasi.
     *
     * Di sinilah kita mendefinisikan logika kustom Fortify.
     */
    public function boot(): void
    {
        // Kustomisasi Logika Autentikasi: Menggunakan 'username' bukan 'email'.
        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('username', $request->username)
                ->first();

            if ($user && Hash::check($request->password, $user->password)) {
                return $user;
            }

            return null;
        });

        // Kustomisasi View: Mengarahkan Fortify untuk menggunakan view login kustom.
        Fortify::loginView(function () {
            return view('auth.login');
        });

        // Registrasi Aksi Fortify (untuk update profil, password, dll.)
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        // Kustomisasi Rate Limiter (Throttling) untuk endpoint login.
        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());
            return Limit::perMinute(5)->by($throttleKey);
        });

        // Rate Limiter untuk Two-Factor (jika diaktifkan).
        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}

/*
|--------------------------------------------------------------------------
| CustomLoginResponse
|--------------------------------------------------------------------------
|
| Class ini berisi logika utama untuk mengarahkan user
| SETELAH MEREKA BERHASIL LOGIN.
|
| Didefinisikan di file yang sama untuk menghindari error Class Not Found
| yang disebabkan oleh caching autoloader.
|
*/
class CustomLoginResponse implements LoginResponseContract
{
    /**
     * Membuat HTTP response berdasarkan role user yang login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        // Ambil instance user yang terautentikasi.
        $user = auth()->user();

        // Tentukan URL redirect default (fallback).
        $redirectUrl = route('landing');

        // Logika Redirect Berdasarkan Role
        if ($user->hasRole('admin')) {
            // Role Admin: Arahkan ke dashboard admin.
            $redirectUrl = route('admin.dashboard');
        } elseif ($user->hasRole('mentor')) {
            // Role Mentor: Periksa status approval.
            if ($user->mentor && $user->mentor->status_approval === 'approved') {
                // Jika disetujui, arahkan ke dashboard mentor.
                $redirectUrl = route('mentor.dashboard');
            } else {
                // Jika status 'pending' atau 'rejected', lakukan logout paksa.
                auth()->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                // Kembalikan ke halaman login dengan pesan error.
                return redirect()->route('login')
                    ->with('error', 'Akun Anda masih menunggu persetujuan admin.');
            }
        } elseif ($user->hasRole('murid')) {
            // Role Murid: Arahkan ke halaman 'pilih-iqra'.
            $redirectUrl = route('murid.pilih-iqra');

            // Untuk role 'murid', lakukan redirect langsung ke 'pilih-iqra'.
            // Metode `intended()` sengaja tidak digunakan di sini untuk
            // memastikan murid tidak diarahkan ke rute fallback (spt /dashboard)
            // yang mungkin mereka coba akses sebelum login.
            return $request->wantsJson()
                ? new JsonResponse(['two_factor' => false])
                : redirect($redirectUrl);
        }

        // Default Response (untuk Admin, Mentor, dan Fallback)
        // Gunakan `intended()` agar user diarahkan ke halaman yang
        // mereka tuju sebelumnya (jika ada).
        return $request->wantsJson()
            ? new JsonResponse(['two_factor' => false])
            : redirect()->intended($redirectUrl);
    }
}
