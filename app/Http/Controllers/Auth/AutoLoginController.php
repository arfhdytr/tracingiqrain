<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AutoLoginController extends Controller
{
    /**
     * Auto login user dari session dan redirect ke pilih iqra
     */
    public function autoLogin()
    {
        $userId = session('pending_login_user_id');

        if (!$userId) {
            return redirect()->route('login');
        }

        $user = User::find($userId);

        if (!$user) {
            session()->forget('pending_login_user_id');
            return redirect()->route('login');
        }

        // Auto login
        Auth::login($user);

        // Clear session
        session()->forget('pending_login_user_id');

        // Redirect ke pilih iqra
        return redirect()->route('murid.pilih-iqra');
    }
}
