<?php

use App\Models\Member;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user can view members index', function () {
    $user = User::factory()->create();
    Member::factory()->count(3)->create();

    $response = $this->actingAs($user)->get('/members');

    $response->assertStatus(200);
    $response->assertSee('Members'); // assuming view has this
});

test('user can create member', function () {
    $user = User::factory()->create();

    $data = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '123456789',
    ];

    $response = $this->actingAs($user)->post('/members', $data);

    $response->assertRedirect('/members');
    $this->assertDatabaseHas('members', $data);
});

test('user cannot create member with duplicate email', function () {
    $user = User::factory()->create();
    Member::factory()->create(['email' => 'john@example.com']);

    $data = [
        'name' => 'Jane Doe',
        'email' => 'john@example.com',
        'phone' => '987654321',
    ];

    $response = $this->actingAs($user)->post('/members', $data);

    $response->assertRedirect();
    $response->assertSessionHasErrors('email');
});

test('user can view member details', function () {
    $user = User::factory()->create();
    $member = Member::factory()->create();
    Transaction::factory()->count(2)->create(['member_id' => $member->id]);

    $response = $this->actingAs($user)->get("/members/{$member->id}");

    $response->assertStatus(200);
});

test('user can view member details with type filter', function () {
    $user = User::factory()->create();
    $member = Member::factory()->create();
    Transaction::factory()->create(['member_id' => $member->id, 'type' => 'topup']);
    Transaction::factory()->create(['member_id' => $member->id, 'type' => 'deduction']);

    $response = $this->actingAs($user)->get("/members/{$member->id}?type=topup");

    $response->assertStatus(200);
});

test('user can search members', function () {
    $user = User::factory()->create();
    Member::factory()->create(['name' => 'Alice']);
    Member::factory()->create(['name' => 'Bob']);

    $response = $this->actingAs($user)->get('/members?search=Alice');

    $response->assertStatus(200);
    $response->assertSee('Alice');
    $response->assertDontSee('Bob');
});
