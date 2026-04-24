<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTwoFactor
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if (auth()->check() && ($user->role === 'admin' || $user->email === 'safullahzafar@gmail.com')) {
            // Check if 2FA session is active
            if (!$request->session()->has('2fa_verified')) {
                if (!$request->is('verify*') && !$request->is('logout')) {
                    return redirect()->route('verify.index');
                }
            }
        }

        return $next($request);
    }
}
