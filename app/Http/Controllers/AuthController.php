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

    //What should this action return?
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
}