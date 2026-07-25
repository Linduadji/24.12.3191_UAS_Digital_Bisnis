<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            // Jika mengakses route 'admin', redirect ke 'admin.login'
            if ($request->segment(1) === 'admin') {
                return redirect()->route('admin.login');
            }
            // Jika mengakses route lain, redirect ke 'login'
            return redirect()->route('login');
        }

        return $next($request);
    }
}
