<?php 

namespace App\Services;

use App\Interfaces\AuthServiceInterface;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;

class AuthService implements AuthServiceInterface {

    public function register(array $data): User | bool {
        try {
            $user = new User();
            $user->name = $data['username'];
            $user->email = $data['email'];
            $user->password = Hash::make($data['password']);
            $user->save();
            $user->sendEmailVerificationNotification();

            return $user;
        }
        catch(Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
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
            Log::error($e->getMessage());
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
            Log::error($e->getMessage());
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
            Log::error($e->getMessage());
            return false;
        }
    }

    public function requestPasswordReset(int $userId): bool {
        try {
            $user = User::where('id', $userId)->first();
            $token = Password::getRepository()->create($user);
    
            if(empty($user) || empty($token)) {
                throw new Exception('Could not create a password reset token.');
            }
            
            $user->sendPasswordResetNotification($token);
            return true;
        }
        catch(Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function resetPassword(array $data): bool {
        try {
            $token = DB::table('password_reset_tokens')->where('token', $data['token'])->first();

            $expirationTime = now()->subMinutes(config('auth.passwords.users.expire'));
            if($token->created_at < $expirationTime) {
                throw new Exception('Provided token is expired.');
            }

            if(empty($token)) {
                throw new Exception('Provided token is invalid or password has been reset before.');
            }

            $user = User::where('email', $token->email)->first();

            if(empty($user)) {
                throw new Exception('Provided token is invalid or password has been reset before.');
            }

            $user->password = Hash::make($data['password']);
            $user->save();
            
            DB::table('password_reset_tokens')->where('token', $data['token'])->delete();

            return true;
        }
        catch(Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
}