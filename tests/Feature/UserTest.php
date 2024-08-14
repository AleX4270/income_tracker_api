<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use Webmozart\Assert\Assert;

class UserTest extends TestCase
{

    use RefreshDatabase; //A trait to make test in a "transaction".

    /**
     * User login action tests
     */
    public function test_user_successful_login(): void
    {
        $user = User::factory()->create([
            'name' => 'test',
            'email' => 'test@income-tracker.com',
            'password' => Hash::make('ExamplePassword123*')
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => 'test@income-tracker.com',
            'password' => 'ExamplePassword123*'
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('status', 200)
                ->has('data', fn (AssertableJson $json) =>
                $json->where('username', $user->name)
                    ->has('token')
                )
            );
    }

    public function test_login_with_wrong_email(): void
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => 'test2@income-tracker.com',
            'password' => 'ExamplePassword123*'
        ]);

        $response
            ->assertStatus(401)
            ->assertJson(fn(AssertableJson $json) =>
                $json->where('status', 401)
                ->where('error', 'Invalid credentials!')
            );
    }

    public function test_login_with_wrong_password(): void
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => 'test@income-tracker.com',
            'password' => 'ExamplePassword1232*'
        ]);

        $response
            ->assertStatus(401)
            ->assertJson(fn(AssertableJson $json) =>
            $json->where('status', 401)
                ->where('error', 'Invalid credentials!')
            );
    }

    /**
     * User register action tests
     */
//    public function test_user_successful_registration(): void {
//
//    }
}
