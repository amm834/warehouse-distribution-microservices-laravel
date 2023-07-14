<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if (!auth()->attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $token = auth()->user()->createToken('auth_token')->accessToken;

        return response()->json([
            'access_token' => $token,
        ], 200);
    }
}
