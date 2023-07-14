<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Database\DatabaseManager;

class RegisterController extends Controller
{
    public function __construct(
        private readonly DatabaseManager $databaseManager,
    )
    {
    }

    public function __invoke(RegisterRequest $request)
    {
        try {
            $user = $this->databaseManager->transaction(
                callback: fn() => User::create($request->validated()),
                attempts: 3
            );

            return response()->json([
                'message' => 'User created successfully',
                'user' => $user,
            ], 201);
        } catch (\Throwable $exception) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $exception->getMessage(),
            ], 500);
        }
    }
}
