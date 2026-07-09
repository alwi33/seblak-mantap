<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Pastikan user yang login benar-benar admin (is_admin = true) sebelum
     * boleh mengakses halaman apa pun di bawah /admin/*.
     *
     * Middleware 'auth' saja tidak cukup di sini: 'auth' hanya memastikan
     * ada user yang login (siapa saja, termasuk pelanggan yang baru daftar
     * lewat /register), bukan memastikan usernya admin toko.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user || !$user->is_admin) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->with('error', 'Akun ini tidak memiliki akses ke panel admin.');
        }

        return $next($request);
    }
}
