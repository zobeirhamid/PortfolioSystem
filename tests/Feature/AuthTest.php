<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthTest extends TestCase
{
    use DatabaseMigrations;
    /** @test */
    public function user_gets_token_after_successful_login(){
        $user = factory(\App\User::class)->create();

        $response = $this->postJson('/api/login', ['email' => $user->email, 'password' => 'secret'])
            ->assertStatus(200);
    }

    /** @test */
    public function guests_cannot_access_guarded_routes_and_getting_instead_a_401(){
        $response = $this->getJson('/api/test')
            ->assertStatus(401);
    }

    /** @test */
    public function signed_in_users_can_access_guarded_routes(){
        $user = factory(\App\User::class)->create();

        $response = $this->actingAs($user)->getJson('/api/test')
            ->assertStatus(200);
    }
}
