<?php 

namespace App\Services;

use App\Interfaces\AuthServiceInterface;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthService implements AuthServiceInterface {

    public function register(array $data): array {
        $user = new User();
        $user->name = $data['username'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->save();

        return [
            'message' => 'User registered successfully.'
        ];
    }

    public function login(array $data): array {
        try {
            $user = User::where('email', $data['email'])->first();
    
            if(empty($user) || !Hash::check($data['password'], $user->password)) {
                throw new Exception('Invalid credentials!'); //Is there a better way to do this?
            }
            $token = $user->createToken($user->name . 'web_token');
    
            return [
                'username' => $user->name,
                'token' => $token->plainTextToken
            ];
        }
        catch(Exception $e) {
            //Log this error to laravel?

            return [
                'error' => $e->getMessage(),
            ];
        }
    }

    public function logout(User $user): array {
        //Consider deleting only the "request" token in the future (mobile app support?)
        $user->tokens()->delete();

        return [
            'message' => 'User logged out successfully!'
        ];
    }
}