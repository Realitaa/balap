<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, int $requiredRole): Response
    {
        // Ambil role pengguna yang sedang login
        $userRole = (int) Auth::user()->role;

        // Jika role user tidak sesuai dengan yang diizinkan, tolak akses
        if ($userRole !== $requiredRole) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
