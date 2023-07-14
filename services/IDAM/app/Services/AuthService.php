<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Facades\Cache;
use App\Enum\Cache as CacheEnum;

class AuthService
{

    public function __construct(
        private readonly DatabaseManager $databaseManager,
    )
    {
    }

    public function createUser($data): User
    {
        return $this->databaseManager->transaction(function () use ($data) {
            return User::create($data);
        }, 3);
    }

    public function createToken(User $user): string
    {
        $token = hash_hmac('sha256', $user->email, config('app.key'));
        Cache::put(
            key: $token,
            value: [
                'id' => $user->id,
                'role' => $user->getAttribute('role'),
            ],
            ttl: CacheEnum::MINUTE->value, // 60 minutes
        );
        return $token;
    }
}
