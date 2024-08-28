<?php 

namespace App\Services;

use App\Interfaces\AuthServiceInterface;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Symfony\Component\Process\ExecutableFinder;

class AuthService implements AuthServiceInterface {

    public function register(array $data): User {
        $user = new User();
        $user->name = $data['username'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->save();
        $user->sendEmailVerificationNotification();

        return $user;
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
            return [];
        }
    }

    public function logout(User $user): bool {
        //Consider deleting only the "request" token in the future (mobile app support?)
        return $user->tokens()->delete();
    }

    public function verifyEmail(int $userId): bool {
        try {
            $user = User::where('id', $userId)->first();
            if($user->hasVerifiedEmail() || !$user->markEmailAsVerified()) {
                throw new Exception('Could not mark the user\'s email as verified or the email has been already verified.');
            }
    
            return true;
        }
        catch(Exception $e) {
            //TODO: Log?
            return false;
        }
    }

    public function resendEmail(User $user): bool {
        try {
            if($user->hasVerifiedEmail() || !$user->sendEmailVerificationNotification()) {
                throw new Exception('Could not resend the verification email or the email has been already verified.');
            }

            return true;
        }
        catch(Exception $e) {
            //TODO: Log?
            return false;
        }
    }

    public function resetPassword(int $userId): array {
        // try {
        //     $user = User::where('id', $userId)->first();
        //     $token = Password::getRepository()->create($user);
    
        //     if(empty($user) || empty($token)) {
        //         //error
        //     }
        //     $user->sendPasswordResetNotification($token);
        // }
        // catch(Exception $e) {
        //     //Log to laravel
        //     return ['error' => $e->getMessage()];
        // }
    }
}