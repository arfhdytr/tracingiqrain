<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {

                // Ambil user yang sedang login
                $user = Auth::guard($guard)->user();

                // Cek role dan redirect ke dashboard yang sesuai
                if ($user->hasRole('admin')) {
                    return redirect(route('admin.dashboard'));
                }

                if ($user->hasRole('mentor')) {
                    // Asumsi: jika user bisa 'check()', berarti dia sudah login
                    // dan sudah diapprove (karena logic block ada di LoginResponse)
                    return redirect(route('mentor.dashboard'));
                }

                if ($user->hasRole('murid')) {
                    return redirect(route('murid.pilih-iqra'));
                }

                // Fallback jika user punya role aneh atau tidak terdaftar
                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
