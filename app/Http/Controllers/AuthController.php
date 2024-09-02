<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordResetRequest;
use App\Interfaces\AuthServiceInterface;
use Illuminate\Http\Request;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Response;

class AuthController extends Controller {
    public function __construct(
        protected AuthServiceInterface $authService
    ) {}

    public function register(UserRegisterRequest $request): ApiResponse {
        $response = new ApiResponse();
        $result = $this->authService->register($request->validated());

        if(!empty($result)) {
            $response->message = 'User registered succesfully';
        }
        else {
            $response->status = Response::HTTP_INTERNAL_SERVER_ERROR;
            $response->message = 'An error occured while trying to register a new user.';
        }

        return $response;
    }

    public function login(UserLoginRequest $request): ApiResponse {
        $response = new ApiResponse();
        $result = $this->authService->login($request->validated());
        
        if(!empty($result)) {
            $response->data = $result;
            $response->message = 'User logged in successfully.';
        }
        else {
            $response->status = Response::HTTP_UNAUTHORIZED;
            $response->message = 'An error occured while trying to log in the user.';
        }

        return $response;
    }

    public function logout(Request $request): ApiResponse {
        $response = new ApiResponse();
        $result = $this->authService->logout($request->user());

        if($result) {
            $response->message = 'User logged out successfully.';
        }
        else {
            $response->status = Response::HTTP_INTERNAL_SERVER_ERROR;
            $response->message = 'Could not log out the user.';
        }

        return $response;
    }

    public function verifyEmail(Request $request): ApiResponse {
        $response = new ApiResponse();
        $userId = $request->input('id');

        if(empty($userId)) {
            $response->status = Response::HTTP_BAD_REQUEST;
            $response->message = 'Invalid parameters. User id must be provided.';
            return $response;
        }

        $result = $this->authService->verifyEmail($userId);
        
        if($result) {
            $response->message = 'Email has been verified successfully.';
        }
        else {
            $response->status = Response::HTTP_INTERNAL_SERVER_ERROR;
            $response->message = 'Could not verify the email or the email has been already verified.';
        }

        return $response;
    }

    public function resendEmail(Request $request): ApiResponse {
        $response = new ApiResponse();
        $result = $this->authService->resendEmail($request->user());

        if($result) {
            $response->message = 'Email verification link has been sent.';
        }
        else {
            $response->status = Response::HTTP_INTERNAL_SERVER_ERROR;
            $response->message = 'Could not send the email verification link.';
        }

        return $response;
    }

    public function requestPasswordReset(Request $request): ApiResponse {
        $response = new ApiResponse();
        $userId = $request->input('id');

        if(empty($userId)) {
            $response->status = Response::HTTP_BAD_REQUEST;
            $response->message = 'Invalid arguments! User id must be provided.';
            return $response; 
        }

        $result = $this->authService->requestPasswordReset($userId);

        if($result) {
            $response->message = 'Password reset link has been sent.';
        }
        else {
            $response->status = Response::HTTP_INTERNAL_SERVER_ERROR;
            $response->message = 'Could not send the password reset link.';
        }

        return $response;
    }

    public function resetPassword(PasswordResetRequest $request): ApiResponse {
        $response = new ApiResponse();
        $data = $request->validated();

        if(empty($data)) {
            $response->status = Response::HTTP_BAD_REQUEST;
            $response->message = 'Invalid arguments! Token and a new password must be provided.';
            return $response; 
        }

        $result = $this->authService->resetPassword($data);

        if($result) {
            $response->message = 'Password has been reset.';
        }
        else {
            $response->status = Response::HTTP_INTERNAL_SERVER_ERROR;
            $response->message = 'Could not reset the password.';
        }

        return $response;
    }
}