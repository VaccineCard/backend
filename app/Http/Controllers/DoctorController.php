<?php

namespace VaccineCard\Http\Controllers;

use Illuminate\Http\Request;
use VaccineCard\Models\Center;
use VaccineCard\Models\User;
use VaccineCard\Models\UserVaccinator;
use VaccineCard\Models\Vaccinator;

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
            "doctor" => (array) $doctor,
        ], 200);
    }

    /**
     * @method POST
     * @param Request $request
     */
    public function registerDoctor(Request $request)
    {
        $request->validate([
            "center_id" => "required",
            "user_id" => "required",
        ]);

        $newDoctor = (object) $request->only("center_id", "user_id");

        if (!Center::find($newDoctor->center_id)) {
            return response()->json([
                "error" => "The center indicated does not exist!",
            ], 200);
        }

        unset($newDoctor->center_id);

        if (!User::find($newDoctor->user_id)) {
            return response()->json([
                "error" => "The user indicated does not exist!",
            ], 200);
        }

        $newDoctor->state = 1;

        $req = Vaccinator::firstOrNew((array) $newDoctor);

        if (!$req['id']) {
            $req->save();
            return response()->json([
                "success" => "The doctor request was created, please wait confirmation!",
            ], 200);
        }

        return response()->json([
            "warn" => "The doctor request already exists!",
        ], 200);
    }

    /**
     * @method POST
     * @param Request $request
     */
    public function addNewPatient(Request $request)
    {
        $request->validate([
            "user_email" => "required",
            "vaccinator_id" => "required",
        ]);

        $newPacient = (object) $request->only("user_email", "vaccinator_id");

        $user = User::where("email", $newPacient->user_email)->first();

        if (!$user['id']) {
            return response()->json([
                "error" => "User doesn't exists!!!",
            ], 401);
        }

        $newPacient->user_id = $user['id'];

        $newPacient->state = 1;

        unset($newPacient->user_email);

        unset($user);

        $req = UserVaccinator::firstOrNew((array) $newPacient);

        if ($req['id']) {
            return response()->json([
                "warn" => "Already exist an request for this patient, please wait for confirmation!",
            ], 200);
        }

        $req->save();

        return response()->json([
            "success" => "Request was created!",
        ], 201);

    }

    /**
     * @method GET
     * @param int $doctor_id
     */
    public function getAllPatients(int $doctor_id)
    {
        $patients = UserPatients::where('vaccinator_id', $doctor_id)->patients;

        return response()->json([
            "patients" => $patients,
        ], 200);
    }

    /**
     * @method POST
     * @param Request $request
     */
    public function registerVaccine(Request $request)
    {
        $request->validate([
            "vaccinator_id" => "required",
            "vaccine_id" => "required",
        ]);

        $vaccine = $request->only("vaccinator_id", "vaccine_id");

        $addVaccine = \VaccineCard\Models\VaccinatorVaccine::firstOrNew($vaccine);

        if ($addVaccine['id']) {
            return response()->json([
                "warn" => "Already exist this combination.",
            ], 200);
        }

        $addVaccine->save();
        return response()->json([
            "success" => "Vaccine was add to vaccinator",
        ], 201);
    }

    /**
     * @method POST
     * @param Request $request
     */

    public function removePatient(Request $request)
    {
        $request->validate([
            "user_id" => "required",
            "vaccinator_id" => "required",
        ]);

        $newPacient = $request->only("user_id", "vaccinator_id");

        $req = UserVaccinator::where($newPacient)->first();

        if (!$req['id']) {
            return response()->json([
                "error" => "Link not founded",
            ], 200);
        }

        $req->delete();

        return response()->json([
            "success" => "Link was deleted!",
        ], 200);
    }

    /**
     * @method POST
     * @param Request $request
     */
    public function updateInformation(Request $request)
    {
        //
    }
}
