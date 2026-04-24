<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckModulePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, $module, $action = 'view'): Response
    {
        if (!auth()->check()) {
            return redirect('login');
        }

        if (!auth()->user()->hasPermission($module, $action)) {
            // Check if it's an AJAX request to return JSON error
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['error' => 'You do not have permission to access that module.'], 403);
            }

            abort(403, 'Access Denied: You do not have permission to use that feature. Please contact the administrator.');
        }

        return $next($request);
    }
}
