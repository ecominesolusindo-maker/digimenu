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

        if ($user && $user->role === 'owner') {
            $restaurant = $user->restaurant;

            if (!$restaurant) {
                return redirect()->route('subscription.expired')->with('error', 'No restaurant assigned to your account.');
            }

            if (!$restaurant->is_active) {
                return redirect()->route('subscription.expired')->with('error', 'Your restaurant account has been suspended.');
            }

            if ($restaurant->subscription_expires_at && $restaurant->subscription_expires_at->isPast()) {
                return redirect()->route('subscription.expired')->with('error', 'Your subscription has expired. Please contact sales.');
            }
        }

        return $next($request);
    }
}
