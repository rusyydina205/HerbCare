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
        $middleware->trustProxies(at: '*');
        $middleware->validateCsrfTokens(except: [
            'logout',
        ]);
        $middleware->redirectTo(
            guests: function ($request) {
                if ($request->is('practitioner*') || str_contains($request->headers->get('referer', ''), 'practitioner')) {
                    return route('login', ['role' => 'practitioner']);
                }
                return route('login', ['role' => 'patient']);
            }
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Illuminate\Session\TokenMismatchException $e, $request) {
            // Handle session expiration during logout attempts
            if ($request->is('logout') || $request->path() === 'logout') {
                \Illuminate\Support\Facades\Auth::guard('web')->logout();
                \Illuminate\Support\Facades\Auth::guard('practitioner')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect('/');
            }

            // Determine role to redirect to correct login tab on session expiration
            $role = $request->input('role');
            if (!$role) {
                if ($request->is('practitioner*') || str_contains($request->headers->get('referer', ''), 'practitioner')) {
                    $role = 'practitioner';
                } else {
                    $role = 'patient';
                }
            }

            return redirect()->route('login', ['role' => $role])
                ->withInput($request->except('password', '_token'))
                ->with('status', 'Your session expired. Please try signing in again.');
        });
    })->create();
