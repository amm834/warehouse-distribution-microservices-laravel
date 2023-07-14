<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\AuthException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use Illuminate\Contracts\Auth\Factory;

class LoginController extends Controller
{

    public function __construct(
        private readonly Factory     $auth,
        private readonly AuthService $tokenService,
    )
    {
    }

    /**
     * Handle the incoming request.
     * @throws AuthException
     */
    public function __invoke(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$this->auth->guard()->attempt($credentials)) {
            throw  new AuthException('Invalid credentials', 401);
        }

        $accessToken = $this->tokenService->createToken(auth()->user());

        return response()->json([
            'access_token' => $accessToken,
            'token_type' => 'Bearer',
            'expires_in' => auth()->factory()->getTTL() * 60, // 60 minutes
        ]);
    }
}
