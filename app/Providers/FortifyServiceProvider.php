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
    public function toResponse($request)
    {
        $user = auth()->user();
        $redirectUrl = route('landing');

        if ($user->hasRole('admin')) {
            $redirectUrl = route('admin.dashboard');
        } elseif ($user->hasRole('mentor')) {
            if ($user->mentor && $user->mentor->status_approval === 'approved') {
                $redirectUrl = route('mentor.dashboard');
            } else {
                auth()->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('login')
                    ->with('error', 'Akun Anda masih menunggu persetujuan admin.');
            }
        } elseif ($user->hasRole('murid')) {
            // [MODIFIKASI] Cek apakah preferensi sudah terisi
            if ($user->murid && !$user->murid->preferensi_terisi) {
                // Jika belum, arahkan ke halaman setup preferensi
                return redirect()->route('murid.preferensi.form');
            }

            // Jika sudah, lanjut ke pilih iqra
            $redirectUrl = route('murid.pilih-iqra');

            return $request->wantsJson()
                ? new JsonResponse(['two_factor' => false])
                : redirect($redirectUrl);
        }

        return $request->wantsJson()
            ? new JsonResponse(['two_factor' => false])
            : redirect()->intended($redirectUrl);
    }
}