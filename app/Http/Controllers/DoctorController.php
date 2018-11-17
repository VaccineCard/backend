<?php

namespace VaccineCard\Http\Controllers;

use VaccineCard\Models\Vaccinator;
use VaccineCard\Models\Center;
use VaccineCard\Models\User;

use Illuminate\Http\Request;

class DoctorController extends Controller
{
    /**
     * @method GET
     * @param int $doctor_id
     */
    public function getDoctor(int $doctor_id)
    {
        $doctor = (object) [];
        $doctor = Vaccinator::where('id', $doctor_id)
                    ->firstOrFails;
        $doctor->state = ($doctor->state == 1) ? 'Pendente' : 'Confirmado';

        $doctor->info = Vaccinator::where('id', $doctor_id)->user;

        return response()->json([
            "doctor" => (array) $doctor
        ], 200);
    } 

    /**
     * @method POST
     * @param Request $request
     */
    public function registerDoctor(Request $request) {
        $request->validate([
            "center_id" => "required",
            "user_id" => "required",
        ]);
        
        $newDoctor = (object) $request->only("center_id", "user_id");
        
        if(!Center::find($newDoctor->center_id)) {
            return response()->json([
                "error" => "The center indicated does not exist!"
            ], 200);
        }
        
        unset($newDoctor->center_id);

        if(!User::find($newDoctor->user_id)) {
            return response()->json([
                "error" => "The user indicated does not exist!"
            ], 200);
        }

        $newDoctor->state = 1;

        $req = Vaccinator::firstOrNew((array) $newDoctor);

        if(! $req['id']) {
            $req->save();
            return response()->json([
                "success" => "The doctor request was created, please wait confirmation!"
            ], 200);
        }

        return response()->json([
            "warn" => "The doctor request already exists!"
        ], 200);
    }

    public function addNewPacient(Request $request) {
        $request->validate([
            "user_id" => "required",
            "vaccinator_id" => "required"
        ]);
        
        $newPacient = ( object ) $request->only("user_id", "vaccinator_id");

        $user = (object) User::where("email", $newPacient->user_id)
                    ->orWhere("phone", $newPacient->user_id)
                    ->firstOrFail();

        $newPacient->user_id = $user->id;

        unset($user);
        
        $req = UserVaccinator::firstOrNew((array) $newPacient);
    }
}
