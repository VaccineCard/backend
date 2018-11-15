<?php

namespace VaccineCard\Http\Controllers;

use Illuminate\Http\Request;
use VaccineCard\Models\User;

use JWTAuth;

class AuthController extends Controller
{
    public function signin (Request $request) {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        return $this->checkIfUserWasAuthenticate($credentials);
    }

    protected function checkIfUserWasAuthenticate($credentials)
    {
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'error' => 'Invalid Credentials!'
                ], 401);
            }

            $user = User::where("email", $credentials["email"])->first();

            return response()->json([
                    'token' => $token,
                    'user' => $user
                ], 200);

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
