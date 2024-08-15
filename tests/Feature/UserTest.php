<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UserTest extends TestCase {
    use DatabaseTransactions; //A trait to make test in a "transaction".

    /**
     * User login action tests
     */
    public function test_user_successful_login(): void {
        $user = User::factory()->create([
            'name' => 'test',
            'email' => 'test@income-tracker.com',
            'password' => Hash::make('ExamplePassword123*'),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => 'test@income-tracker.com',
            'password' => 'ExamplePassword123*',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(
                fn(AssertableJson $json) => 
                $json
                ->has('data', fn(AssertableJson $json) => $json
                    ->where('username', $user->name)
                    ->has('token')
                )
            );
    }

    public function test_login_with_wrong_email(): void {
        $response = $this->postJson('/api/auth/login', [
            'email' => 'test2@income-tracker.com',
            'password' => 'ExamplePassword123*',
        ]);

        $response
            ->assertStatus(401)
            ->assertJson(
                fn(AssertableJson $json) => $json
                    ->where('error', 'Invalid credentials!')
            );
    }

    public function test_login_with_wrong_password(): void {
        $response = $this->postJson('/api/auth/login', [
            'email' => 'test@income-tracker.com',
            'password' => 'ExamplePassword1232*',
        ]);

        $response
            ->assertStatus(401)
            ->assertJson(
                fn(AssertableJson $json) => $json
                    ->where('error', 'Invalid credentials!')
            );
    }

    /**
     * User register action tests
     */
    public function test_user_successful_registration(): void {
        $user = User::factory()->make();

        $response = $this->postJson('/api/auth/register', [
            'username' => $user->name,
            'email' => $user->email,
            'password'=> $user->password,
            'password_confirmation' => $user->password
        ]);

        $response
        ->assertStatus(200)
        ->assertJson(fn (AssertableJson $json) =>
            $json
            ->has('data', fn (AssertableJson $json) => 
                $json
                ->where('message', 'User registered successfully.')
            )    
        );
    }

    public function test_registration_with_missing_or_existing_data(): void {
        $user = User::factory()->make();

        $response = $this->postJson('/api/auth/register', [
            'username' => $user->name,
            'password'=> $user->password,
            'password_confirmation' => $user->password
        ]);

        $response
        ->assertStatus(422)
        ->assertJson(fn (AssertableJson $json) => 
            $json
            ->has('message')
            ->has('errors', fn (AssertableJson $json) => 
                $json
                ->hasAny(['password', 'email', 'username'])
            )
        );
    }

    // public function test_user_successful_logout(): void {
    //     //Login some user
    //     //Send the logout request with that user data
    //     //check the response
    //     $user = User::factory()->create();

    //     $response = $this->actingAs($user, 'web')
    //     ->postJson('/api/auth/logout', []);

    //     $response
    //     ->assertStatus(200)
    //     ->assertJson(fn (AssertableJson $json) => 
    //         $json
    //         ->has('data', fn (AssertableJson $json) => 
    //             $json
    //             ->has('message')
    //         )
    //     );
    // }
}
