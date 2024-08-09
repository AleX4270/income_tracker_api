<?php

namespace App\Http\Controllers;

use App\Interfaces\AuthServiceInterface;
use Illuminate\Http\Request;
use App\Http\Requests\UserRegisterRequest;

class AuthController extends Controller {
    public function __construct(
        protected AuthServiceInterface $authService
    ) {}

    //What should this action return?
    //It doesn't return an error when not validated, just a regular 200.
    public function register(UserRegisterRequest $request) {
        //Get the data (validated)
        $data = $request->validated();
        // $result = $this->authService->register($data);

        return response()->json($data);
        //Return the token along with username and language?.
    }

    public function login(Request $request) {
        //TODO login
    }

    public function logout(Request $request) {
        //Is it necessary?
    }
}