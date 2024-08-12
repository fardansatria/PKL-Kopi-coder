<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserProfileExists
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user) {
            $user->profile->updateOrCreate(
                [
                    'profile_image' => 'default.png', // Gambar default
                    'address' => '',
                    'phone' => '',
                ]
            );
        }

        return $next($request);
    }
}
