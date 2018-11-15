<?php

namespace VaccineCard\Http\Controllers;

use Tymon\JWTAuth\Exception\JWTException;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use VaccineCard\Models\UserVaccine;
use VaccineCard\Models\Vaccine;
use VaccineCard\Models\User;

class UserController extends Controller
{
   public function getUserInformationById(int $id) {
        $userById = User::where('id', $id)
                    ->first();
        
        if($userById)
            return response()->json([
                'user' => $userById
            ], 200);
        else
            return response()->json([
                'error' => 'No users founded!'
            ], 404);

   }

   public function updateUserInformation(Request $request) {
       // Only fields with modifications
   }
   
   public function getAllUserVaccines(int $user_id) {

        // Get data in user_vaccines and vaccines
        $vaccineList =  DB::table('vaccines')
            ->where('user_vaccines.user_id', $user_id)
            ->join('user_vaccines', 'user_vaccines.vaccine_id', '=', 'vaccines.id')
            ->select('user_vaccines.*', 'vaccines.*')
            ->get();

        // Add vaccinator to list
        foreach($vaccineList as $key => $item){
            $vaccinator = DB::table('users')
                ->where('id', $vaccineList[$key]->user_id)
                ->select('users.name', 'users.email')
                ->first();
            
                // Remove extra fields
                unset(
                    $vaccineList[$key]->user_id,
                    $vaccineList[$key]->vaccinator_id,
                    $vaccineList[$key]->vaccine_id,
                    $vaccineList[$key]->created_at
                );


            $vaccineList[$key]->vaccinator = $vaccinator;
        }

        return response()->json([
            'vaccines' => $vaccineList
        ], 200);
   }

}
