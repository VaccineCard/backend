<?php

namespace VaccineCard\Http\Controllers;

use Illuminate\Http\Request;
use VaccineCard\Models\FamilyLink;
use VaccineCard\Models\User;

class FamilyController extends Controller
{
    public function getMembers (int $user_id) {
        $myFamilyMembers = User::find($user_id)->families;

       foreach($myFamilyMembers as $key => $member) {
            $membersList = User::where('id', $member->family_id)
                                ->select('name', 'phone')->first();

            $myFamilyMembers[$key]->family_name = $membersList->name;
            $myFamilyMembers[$key]->phone = $membersList->phone; 
        } 

        return response()->json([
            'members' => $myFamilyMembers
        ], 200); 
    }

    public function getInformationByMember (int $member_id) {
        
    }
}
