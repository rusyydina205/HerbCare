<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsPractitioner
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! \Illuminate\Support\Facades\Auth::guard('practitioner')->check()) {
            return redirect()->route('login', ['role' => 'practitioner'])
                ->with('status', 'Please sign in as a practitioner to access this page.');
        }

        return $next($request);
    }
}
