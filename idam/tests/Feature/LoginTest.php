<?php


use function Pest\Laravel\postJson;

test('user should be authorize', function () {
    postJson('/api/login', [
        'email' => 'amm@gmail.com',
        'password' => 'password'
    ])->assertStatus(200);
});

test('auth should fail', function () {
    postJson('/api/login', [
        'email' => 'nowhere@gmail.com',
        'password' => 'password'
    ])->assertStatus(401);
});

