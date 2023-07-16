<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Cache;

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


        $token = auth()->user()->createToken('access_token')->accessToken;

        $auth = Cache::remember($token, 60 * 60 * 60, function () use ($token) {
            return [
                'id' => auth()->user()->id,
                'name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ];
        });
        return response()->json([
            'access_token' => $token,
        ], 200);
    }
}
