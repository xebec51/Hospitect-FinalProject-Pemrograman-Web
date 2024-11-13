<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request  $request
     * @param \Closure  $next
     * @param string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Periksa apakah pengguna sudah diautentikasi
        if (!Auth::check()) {
            return redirect('/login'); // Arahkan ke halaman login jika belum masuk
        }

        // Periksa apakah pengguna memiliki peran yang sesuai
        if (Auth::user()->role !== $role) {
            return abort(403, 'Unauthorized'); // Tampilkan kesalahan jika peran tidak cocok
        }

        return $next($request);
    }
}
