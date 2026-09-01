<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsurePublicPinVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Logged in users bypass public PIN prompt
        if (Auth::check()) {
            return $next($request);
        }

        // 2. If session already has verified PIN, allow access
        if ($request->session()->get('public_pin_verified')) {
            return $next($request);
        }

        // 3. Check if preview route is accessed while preview PIN protection is ON
        $isPreviewRoute = $request->routeIs('public.preview');
        $pinPreviewEnabled = (string) Setting::get('public_preview_pin_enabled', '0') === '1';

        if ($isPreviewRoute && $pinPreviewEnabled) {
            session(['url.intended' => $request->fullUrl()]);
            return redirect()->route('public.search', ['modal' => 'pin']);
        }

        // For search routes (/ & /arsip), allow the request through so search.blade.php can render the PIN Modal overlay
        return $next($request);
    }
}
