<?php

namespace App\Interfaces;

use App\Models\User;

interface AuthServiceInterface {
    public function register(array $data): array;
    public function login(array $data): array;
    public function logout(User $user): array;
    public function verifyEmail(int $userId): array;
    public function resendEmail(User $user): array;
}