<?php

namespace App\Http\Controllers\Api;

use App\Models\Company;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user  = Auth::user();
            $token = $user->createToken('users')->plainTextToken;

            return response()->json([
                'success' => true,
                'data'    => $token,
                'user'    => $user,
            ]);
        }

        return response()->json([
            'success' => false,
            'code'    => 500,
            'message' => 'Invalid credentials',
        ]);
    }
}
