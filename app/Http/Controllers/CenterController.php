<?php

namespace VaccineCard\Http\Controllers;

use Illuminate\Http\Request;
use VaccineCard\Models\Center;
use VaccineCard\Models\State;
use VaccineCard\Models\VaccineCenter;

class CenterController extends Controller
{
    /**
     * @method POST
     * @param Request $request
     */
    public function createNewCenter(Request $request)
    {
        $request->validate([
            "name" => "required",
            "state_id" => "required|integer",
            "country_id" => "required|integer",
            "focus" => "required",
            "latitude" => "required",
            "longitude" => "required",
        ]);

        $center = $request->only("name", "state_id", "country_id", "focus", "latitude", "longitude");

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
     */

    public function getVaccineCenters(int $vaccine_id, string $category)
    {

        // Comming data like  { vaccine_id and category center }
        $centers = VaccineCenter::where('vaccine_id', $vaccine_id)
            ->first();

        $avalibleCenters = [];
        if (!empty($centers)) {
            $avalibleCenters = $centers->centers($category);
        }

        foreach ($avalibleCenters as $key => $center) {
            $avalibleCenters[$key]["state_id"] = State::find($center['id'])['name'];
            $avalibleCenters[$key]["country_id"] = State::find($center['id'])->country['name'];

        }

        return response()->json([
            "centers" => $avalibleCenters,
        ], 200);
    }

    /**
     * @method POST
     * @param Request $request
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
}
