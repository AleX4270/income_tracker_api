<?php

namespace App\Http\Controllers;

use App\Interfaces\AuthServiceInterface;
use Illuminate\Http\Request;

class AuthController extends Controller {
    public function __construct(
        protected AuthServiceInterface $authService
    ) {}

    public function register(Request $request) {
        return $this->authService->register([]);

        //Get the data?
        //Validate the request data
        //Create a new user if it doesn't exist.
        //Generate a special token for the user.
        //Return the token along with username and language?.
    }

    public function login(Request $request) {
        //TODO login
    }

    public function logout(Request $request) {
        //Is it necessary?
    }
}
