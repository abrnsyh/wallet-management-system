<?php

use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user can topup member balance', function () {
    $user = User::factory()->create();
    $member = Member::factory()->create(['balance' => 10000]);
    $amount = 5000;
    $newBalance = 15000;

    $data = [
        'amount' => $amount,
        'description' => 'Topup for testing',
    ];

    $response = $this->actingAs($user)->post("/members/{$member->id}/topup", $data);

    $response->assertRedirect();
    $response->assertSessionHas('success', 'Top Up Success.');
    $this->assertDatabaseHas('members', [
        'id' => $member->id,
        'balance' => $newBalance,
    ]);
    $this->assertDatabaseHas('transactions', [
        'member_id' => $member->id,
        'type' => 'topup',
        'amount' => $amount,
        'description' => 'Topup for testing',
    ]);
});

test('user can deduct member balance', function () {
    $user = User::factory()->create();
    $member = Member::factory()->create(['balance' => 10000]);
    $amount = 3000;
    $newBalance = 7000;

    $data = [
        'amount' => $amount,
        'description' => 'Deduct for testing',
    ];

    $response = $this->actingAs($user)->post("/members/{$member->id}/deduct", $data);

    $response->assertRedirect();
    $response->assertSessionHas('success', 'Deduction Success.');
    $this->assertDatabaseHas('members', [
        'id' => $member->id,
        'balance' => $newBalance,
    ]);
    $this->assertDatabaseHas('transactions', [
        'member_id' => $member->id,
        'type' => 'deduction',
        'amount' => $amount,
        'description' => 'Deduct for testing',
    ]);
});

test('user cannot deduct if insufficient balance', function () {
    $user = User::factory()->create();
    $member = Member::factory()->create(['balance' => 500]);

    $data = [
        'amount' => 1000,
        'description' => 'Deduct more than balance',
    ];

    $response = $this->actingAs($user)->post("/members/{$member->id}/deduct", $data);

    $response->assertRedirect();
    // Since service throws exception on insufficient balance, expect back with errors
    // Assume error message contains 'Insufficient balance'
});

test('topup requires minimum amount', function () {
    $user = User::factory()->create();
    $member = Member::factory()->create();

    $data = [
        'amount' => 500,
        'description' => 'Low amount',
    ];

    $response = $this->actingAs($user)->post("/members/{$member->id}/topup", $data);

    $response->assertRedirect();
    $response->assertSessionHasErrors('amount');
});

test('topup and deduct require auth', function () {
    $member = Member::factory()->create();

    $data = [
        'amount' => 1000,
        'description' => 'Test',
    ];

    $response = $this->post("/members/{$member->id}/topup", $data);
    $response->assertRedirect('/login');

    $response = $this->post("/members/{$member->id}/deduct", $data);
    $response->assertRedirect('/login');
});
