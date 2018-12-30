<?php

namespace VaccineCard\Http\Controllers;

use Illuminate\Http\Request;
use VaccineCard\Models\FamilyLink;
use VaccineCard\Models\User;

class FamilyController extends Controller
{
    /**
     * @method GET
     * @param int $user_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMembers(int $user_id)
    {
        $myFamilyMembers = User::find($user_id)->families;

        foreach ($myFamilyMembers as $key => $member) {
            $membersList = User::where('id', $member->family_id)
                ->select('name', 'phone')->first();

            $myFamilyMembers[$key]->family_name = $membersList->name;
            $myFamilyMembers[$key]->phone = $membersList->phone;
        }

        return response()->json([
            'members' => $myFamilyMembers,
        ], 200);
    }

    /**
     * @method POST
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addNewMember(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'family_email' => 'required',
            'grade' => 'required'
        ]);

        $newMember = (object) $request->only('user_id', 'family_email');

        $familyUser = User::where('email', $newMember->family_email)->firstOrFail();

        $newMember->family_id = $familyUser->id;
        $newMember->state = 1;

        unset($newMember->family_email);
        unset($familyUser);

        $res = FamilyLink::firstOrNew((array) $newMember);

        if (!$res['id']) {

            $res->save();
            return response()->json([
                'success' => 'Pedido de ligação feito!',
            ], 201);
        } else {
            return response()->json([
                'warn' => 'Já existe um pedido efectuado!',
            ], 200);
        }

    }

    /**
     * @method POST
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function confirmMember(Request $request)
    {
        $request->validate([
            'link_id' => 'required',
            'method' => 'required',
        ]);

        $queue = (object) $request->only('link_id', 'method');
        $family = FamilyLink::find($queue->link_id);

        if ($family->state === 1) {
            if ($queue->method) {
                $family->update(['state' => 2]);
                return response()->json([
                    "success" => "The family state was updated!",
                ], 200);
            }

            $family->delete();
            return response()->json([
                "warn" => "The family link was deleted!",
            ], 200);
        }
        return response()->json([
            "error" => "Request unauthorized",
        ], 401);
    }

}
