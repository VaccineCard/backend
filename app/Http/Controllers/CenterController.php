<?php

namespace VaccineCard\Http\Controllers;

use Illuminate\Http\Request;
use VaccineCard\Models\Center;
use VaccineCard\Models\State;
use VaccineCard\Models\VaccinatorCenter;
use VaccineCard\Models\VaccineCenter;

class CenterController extends Controller
{
    /**
     * @method POST
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createNewCenter(Request $request)
    {
        $request->validate([
            "name" => "required",
            "state_id" => "required|integer",
            "country_id" => "required|integer",
            // "focus" => "required",
            "latitude" => "required",
            "longitude" => "required",
        ]);

        $center = $request->only("name", "state_id", "country_id", "latitude", "longitude");

        $create = Center::firstOrNew($center);

        if ($create['id']) {
            return response()->json([
                "warn" => "Center already exists!",
            ], 200);
        }

        $create->save();

        return response()->json([
            "success" => "Center was created!",
        ], 201);
    }

    /**
     * @method GET
     * @param String $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCenterByCategory(String $category)
    {

        $centers = Center::where('focus', $category)->get();

        return response()->json([
            "centers" => $centers,
        ], 200);

    }

    /**
     * @method GET
     * @param int $vaccine_id
     * @param string $category
     * @return \Illuminate\Http\JsonResponse
     */

    public function getVaccineCenters(int $vaccine_id, string $category)
    {

        // Coming data like  { vaccine_id and category center }
        $centers = VaccineCenter::where('vaccine_id', $vaccine_id)
            ->first();

        $availableCenters = [];
        if (!empty($centers)) {
            $availableCenters = $centers->vaccines($category);
        }

        foreach ($availableCenters as $key => $center) {
            $availableCenters[$key]["state_id"] = State::find($center['id'])['name'];
            $availableCenters[$key]["country_id"] = State::find($center['id'])->country['name'];
            $availableCenters[$key]["latitude"] = Center::find($center['id'])['latitude'];
            $availableCenters[$key]["longitude"] = Center::find($center['id'])['longitude'];

        }

        return response()->json([
            "centers" => $availableCenters,
        ], 200);
    }

    /**
     * @method POST
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addNewVaccineToCenter(Request $request)
    {

        $request->validate([
            "vaccine_id" => "required|integer",
            "center_id" => "required|integer",
        ]);

        $newVaccineCenter = $request->only("vaccine_id", "center_id");

        $newVaccineCenter["state"] = 1;

        $register = VaccineCenter::firstOrNew($newVaccineCenter);

        if (!$register['id']) {
            $register->save();

            return response()->json([
                "success" => "Vaccine was add to the center",
            ], 201);
        }

        return response()->json([
            "error" => "The vaccine already exists",
        ], 401);
    }

    /**
     * @method DELETE
     * @param Request $request

     * @return \Illuminate\Http\JsonResponse
     */
    public function removeCenter(Request $request)
    {
        $request->validate([
            'center_id' => "required|integer",
        ]);

        $center = (object) $request->only('center_id');

        $center = Center::where('id', $center->center_id)->first();

        if ($center != null) {
            $center->delete();

            return response()->json([
                "success" => "Center was deleted",
            ], 200);
        }

        return response()->json([
            "error" => "Center does not exists",
        ], 401);
    }

    /**
     * - (Prefixo) doctor {
     *  -(POST) confirm
     *  - (DELETE) remove/{id?}
     *       }
     */

    public function confirmNewDoctor(Request $request)
    {

        $request->validate([
            "doctor_id" => "required",
            "center_id" => "required",
            "method" => "required",
        ]);

        $queue = (object) $request->only('doctor_id', 'center_id', "method");

        $statusOfDoctor = VaccinatorCenter::where("vaccinator_id", $queue->doctor_id)
            ->where("center_id", $queue->center_id)
            ->firstOrFail();

        if ($queue->method) {
            if ($statusOfDoctor->state === 2) {
                return response()->json([
                    "warn" => "The vaccinator has already been confirmed!",
                ], 200);
            }

            $statusOfDoctor->state = 2;
            $statusOfDoctor->save();

            return response()->json([
                "success" => "The vaccinator was confirmed!",
            ], 200);
        }
        if ($statusOfDoctor->state !== 2) {
            $statusOfDoctor->delete();

            return response()->json([
                "success" => "The vaccinator link has deleted!",
            ], 200);
        }

        return response()->json([
            "data" => [],
        ], 200);
    }

    public function removeDoctor(Request $request)
    {
        $request->validate([
            "doctor_id" => "required",
            "center_id" => "required",
        ]);

        $queue = (object) $request->only('doctor_id', 'center_id');

        $deletedDoctor = VaccinatorCenter::where("vaccinator_id", $queue->doctor_id)
            ->where("center_id", $queue->center_id)
            ->delete();

        if (!$deletedDoctor) {

            return response()->json([
                "error" => "The link between Vaccinator and Center, not found!",
            ], 404);
        }

        return response()->json([
            "success" => "The vaccinator link has deleted!",
        ], 200);
    }
}
