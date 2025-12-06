<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureMuridHasPreferensi
{
    /**
     * Handle an incoming request.
     *
     * Middleware ini memastikan murid sudah mengisi pertanyaan preferensi
     * sebelum bisa mengakses halaman apapun di aplikasi.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login dan memiliki role murid
        if (auth()->check() && auth()->user()->hasRole('murid')) {
            $murid = auth()->user()->murid;

            // Jika murid ada dan belum isi preferensi
            if ($murid && !$murid->preferensi_terisi) {
                // Daftar route yang boleh diakses meskipun belum isi preferensi
                $allowedRoutes = [
                    'murid.preferensi.form',
                    'murid.preferensi.store',
                    'logout',
                    'profile.show',
                    'profile.update',
                ];

                // Jika bukan route yang diizinkan, redirect ke form preferensi
                if (!$request->routeIs($allowedRoutes)) {
                    return redirect()->route('murid.preferensi.form')
                        ->with('warning', 'Silakan isi pertanyaan keamanan terlebih dahulu sebelum melanjutkan.');
                }
            }
        }

        return $next($request);
    }
}
