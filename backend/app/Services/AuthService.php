<?php 

namespace App\Services;

use App\Interfaces\AuthServiceInterface;
use App\Models\User;

class AuthService implements AuthServiceInterface {

    public function register(array $data): array {
        //Create a new user if it doesn't exist.
        //Generate a special token for the user.

        return [];
    }

    public function login(array $data): array {
        return [];
    }

    public function logout(User $user): array {
        return [];
    }
}