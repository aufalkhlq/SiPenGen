<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle($request, Closure $next, ...$roles): Response
    {
        $user = $this->getAuthenticatedUser();

        if ($user) {
            \Log::info('Authenticated user: ' . $user->name . ' with role: ' . $user->role);
        } else {
            \Log::info('No authenticated user found.');
        }

        if ($user && in_array($user->role, $roles)) {
            return $next($request);
        }

        return view('/login')->with('error', 'Unauthorized access.');
    }

    protected function getAuthenticatedUser()
    {
        if (Auth::guard('web')->check()) {
            return Auth::guard('web')->user();
        }

        if (Auth::guard('mahasiswa')->check()) {
            return Auth::guard('mahasiswa')->user();
        }

        if (Auth::guard('dosen')->check()) {
            return Auth::guard('dosen')->user();
        }

        return null;
    }
}
