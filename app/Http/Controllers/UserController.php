<?php

namespace VaccineCard\Http\Controllers;

use Tymon\JWTAuth\Exception\JWTException;
use Illuminate\Http\Request;
use VaccineCard\Models\User;

class UserController extends Controller
{
   protected function getUserInformationById(int $id) {
        $user = (object) [];
        $user->info = User::where('id', $id)->firstOrFail();
        $user->vaccines = User::find($id)->vaccines;

        return response()->json([
            "user" => $user,
        ], 200);
   }

   protected function updateUserInformation(Request $request) {
       // Only fields with modifications
   }
   
}
