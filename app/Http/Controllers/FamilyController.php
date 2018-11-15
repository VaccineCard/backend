<?php

namespace VaccineCard\Http\Controllers;

use Illuminate\Http\Request;
use VaccineCard\Models\FamilyLink;
use VaccineCard\Models\User;

class FamilyController extends Controller
{
    public function getMembers (int $user_id) {
        $familiesMembers = FamilyLink::where('user_id', $user_id)
                                        ->where('state', 2)
                                        ->get();
        $membersList = [];

        foreach($familiesMembers as $member) {
            array_push($membersList,  User::where('id', $member->family_id)->first());
        }

        return response()->json([
            'members' => $membersList
        ], 200);
    }
}
