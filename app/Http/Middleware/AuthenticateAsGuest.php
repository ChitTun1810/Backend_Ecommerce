<?php

namespace App\Http\Middleware;

use App\Models\Customer;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateAsGuest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()) {
            $request->user();
        } elseif ($request->hasHeader('Authorization')) {
            $token = PersonalAccessToken::findToken($request->bearerToken());
            if(!$token) {
                return response()->json([
                    'success' => false,
                    'message' => 'Token not found',
                ]);
            }
            $authUser = $token?->tokenable;
            Auth::login($authUser);
        } else {
            $guestUser = Customer::firstOrCreate(
                [
                    'name' => 'guest',
                    'email' => 'guest@gmail.com'
                ], 
                ['password' => bcrypt('password')]
            );
            Auth::login($guestUser);
        }

        return $next($request);
    }
}
