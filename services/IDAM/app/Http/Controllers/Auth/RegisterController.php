<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;

class RegisterController extends Controller
{

    public function __construct(
        private readonly AuthService $authService,
    )
    {
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(RegisterRequest $request)
    {
        try {
            $user = $this->authService->createUser($request->validated());
            $token = $this->authService->createToken($user);
            return response()->json([
                'message' => 'User created successfully',
                'data' => [
                    'user' => $user,
                    'token' => $token,
                ],
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Failed to create user',
                'errors' => [
                    'exception' => $th->getMessage(),
                ],
            ], 500);
        }
    }
}
