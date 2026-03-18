<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminOrPetugas
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $role = auth()->user()->role;
        if ($role !== 'admin' && $role !== 'petugas') {
            return redirect()->route('user.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
