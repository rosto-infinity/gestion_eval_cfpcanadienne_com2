<?php

declare(strict_types=1);

it('returns a successful response', function (): void {
    $response = $this->get('/');

    $response->assertStatus(200);
});

it('can access dashboard as superadmin', function (): void {
    $user = \App\Models\User::factory()->create([
        'role' => \App\Enums\Role::SUPERADMIN,
    ]);

    $response = $this->actingAs($user)->get('/dashboard');

    $response->assertStatus(200);
});
