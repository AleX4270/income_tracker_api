<?php

namespace App\Http\Controllers;

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
        $result = $this->authService->register($request->validated());
        return new ApiResponse($result);
    }

    public function login(UserLoginRequest $request): ApiResponse {
        $result = $this->authService->login($request->validated());
        
        if(empty($result['error'])) {
            return new ApiResponse($result);
        }
        else {
            return new ApiResponse(
                httpCode: Response::HTTP_UNAUTHORIZED,
                errorMessage: $result['error']
            );
        }
    }

    public function logout(Request $request): ApiResponse {
        $result = $this->authService->logout($request->user());
        return new ApiResponse($result);
    }

    public function verifyEmail(Request $request): ApiResponse {
        $userId = $request->input('id');

        if(empty($userId)) {
            return new ApiResponse(
                httpCode: Response::HTTP_BAD_REQUEST,
                errorMessage: 'Invalid parameters. User id cannot be empty.'
            );
        }

        $result = $this->authService->verifyEmail($userId);
        return new ApiResponse($result);
    }

    public function resendEmail(Request $request): ApiResponse {
        $result = $this->authService->resendEmail($request->user());
        return new ApiResponse($result);
    }
}