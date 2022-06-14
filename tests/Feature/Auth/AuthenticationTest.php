<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Database\Factories\ClientFactory;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Artisan::call('migrate:fresh --seed');
        Artisan::call('passport:install');
    }

    // public function test_api_login()
    // {
    //     $body = [
    //         'grant_type' => 'password',
    //         'username' => 'contact@wreative.com',
    //         'password' => 'admin'
    //     ];
    //     $this->json('POST', '/api/auth/login', $body, ['Accept' => 'application/json'])
    //         ->assertStatus(200)
    //         ->assertJsonStructure(['token_type', 'expires_in', 'access_token', 'refresh_token']);
    // }

    // public function test_it_returns_a_valid_token_if_credentials_do_match()
    // {
    //     $user = User::factory()->create([
    //         'email' => $email = 'test@test.com',
    //         'password' => $password = '12345678'
    //     ]);

    //     $client = ClientFactory::new()->asPasswordClient()->create(['user_id' => $user->id]);

    //     $this->json('POST', '/oauth/token', [
    //         'grant_type' => 'password',
    //         'client_id' => $client->id,
    //         'client_secret' => $client->secret,
    //         'username' => $email,
    //         'password' => $password,
    //     ])->assertStatus(200);
    // }
}