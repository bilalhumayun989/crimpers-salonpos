<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'permission' => \App\Http\Middleware\CheckModulePermission::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Illuminate\Database\QueryException $e, \Illuminate\Http\Request $request) {
            // Check for MySQL "Out of range" error (1264) or "Numeric value out of range" (SQLSTATE 22003)
            if (str_contains($e->getMessage(), '1264') || str_contains($e->getMessage(), '22003')) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Maximum value exceeded. Please enter a smaller number.'
                    ], 422);
                }
                return back()->withInput()->withErrors(['amount' => 'Maximum value exceeded. Please enter a smaller number.']);
            }
        });
    })->create();
