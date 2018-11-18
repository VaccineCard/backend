<?php

namespace VaccineCard\Http\Controllers;

use Illuminate\Http\Request;
use VaccineCard\Models\User;

class UserController extends Controller
{
    /**
     * @method GET
     * @param int $country_id
     */
    protected function getUserInformationById(int $user_id)
    {
        $user = (object) [];
        $user->info = User::where('id', $user_id)->firstOrFail();
        $user->vaccines = User::find($user_id)->vaccines;

        return response()->json([
            "user" => $user,
        ], 200);
    }

    /**
     * @method POST
     * @param Request $request
     */
    protected function updateUserInformation(Request $request)
    {
        // Only fields with modifications
    }

}
