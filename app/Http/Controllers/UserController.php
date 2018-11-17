<?php

namespace VaccineCard\Http\Controllers;

use Tymon\JWTAuth\Exception\JWTException;
use Illuminate\Http\Request;
use VaccineCard\Models\User;

class UserController extends Controller
{
   protected function getUserInformationById(int $id) {
        $userById = User::find($id);
        
        if($userById)
            return response()->json([
                'user' => $userById
            ], 200);
        else
            return response()->json([
                'error' => 'No users founded!'
            ], 404);

   }

   protected function updateUserInformation(Request $request) {
       // Only fields with modifications
   }
   
}
