<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends BaseController
{
    /**
     * Register API.
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required',
            'email'       => 'required|email',
            'password'    => 'required',
            'c_password'  => 'required|same:password',
        ]);

        if($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        // Check if the email already exists
        if (User::where('email', $request->email)->exists()) {
            return $this->sendError('Validation Error.', ['email' => 'Email already exists.']);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $success = null;
        if($user) {
            $success['token'] = $user->createToken('auth_token')->plainTextToken;
            $success['name'] = $user->name;
        }

        return $this->sendResponse($success, 'User register successfully.');
    }

    /**
     * Login API.
     */
    public function login(Request $request): JsonResponse
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('auth_token')->plainTextToken;
            $success['name'] = $user->name;
    
            return $this->sendResponse($success, 'User login successfully.');
        } else {
            return $this->sendError('Invalid credentials.', ['error' => 'Unauthorised']);
        }
    }

    /**
     * Logout API.
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return $this->sendResponse([], 'User logout successfully.');
    }

}
