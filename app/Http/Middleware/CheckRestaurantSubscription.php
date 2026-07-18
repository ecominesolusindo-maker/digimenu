<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRestaurantSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Always allow logout requests to pass through
        if ($request->routeIs('filament.owner.auth.logout') || $request->is('owner/logout')) {
            return $next($request);
        }

        if ($user && $user->role === 'owner') {
            $restaurant = $user->restaurant;

            if (!$restaurant) {
                return redirect()->route('subscription.expired')->with('error', 'No restaurant assigned to your account.');
            }

            // Check using subscription_status column (actual DB column)
            if ($restaurant->subscription_status && $restaurant->subscription_status === 'suspended') {
                return redirect()->route('subscription.expired')->with('error', 'Your restaurant account has been suspended.');
            }

            // Check trial expiry using trial_ends_at column (actual DB column)
            if ($restaurant->trial_ends_at && \Carbon\Carbon::parse($restaurant->trial_ends_at)->isPast()) {
                return redirect()->route('subscription.expired')->with('error', 'Your subscription has expired. Please contact sales.');
            }
        }

        return $next($request);
    }
}
