<?php

namespace VaccineCard\Http\Controllers;

use Tymon\JWTAuth\Exception\JWTException;
use Illuminate\Http\Request;
use VaccineCard\Models\User;

use JWTAuth;

class UserController extends Controller
{
    public function signin (Request $request) {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $token = $this->checkIfUserWasAuthenticate($credentials);
        
        $user = User::where("email", $credentials["email"])->first();

        return response()->json([
            'token' => $token,
            'user' => $user
        ], 200);
    }

    protected function checkIfUserWasAuthenticate($credentials)
    {
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'error' => 'Invalid Credentials!'
                ], 401);
            }
            return $token;
        } catch (JWTException $e) {
            return response()->json([
                'error' => 'Could not create token!'
            ], 500);
        }
    }

    public function signup (Request $request) {
        
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'phone' => 'required',
            'birth' => 'required'
        ]);

        $user = $request->only(
            'name',
            'email',
            'password',
            'birth',
            'phone',
            'state_id',
            'country_id',
            'gender'
        );

        $user['password'] = bcrypt($user['password']);
        
        $response = User::create($user);

        return response()->json(['success' => 'User Created with success!!!'], 201);
    }
}
