<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OrganizerMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('organizer.login');
        }

        if (auth()->user()->role !== 'organizer') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses sebagai organizer');
        }

        return $next($request);
    }
}
