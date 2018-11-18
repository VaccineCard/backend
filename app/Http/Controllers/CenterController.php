<?php

namespace VaccineCard\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use VaccineCard\Models\VaccineCenter;
use VaccineCard\Models\Center;
use Illuminate\Http\Request;

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
            "longitude" => "required"
        ]);

        $center = $request->only("name", "state_id", "country_id", "focus", "latitude", "longitude");

        $create = Center::firstOrNew($center);

        if($create['id']) {
            return response()->json([
                "warn" => "Center already exists!"
            ], 200);
        }

        $create->save();

        return response()->json([
            "success" => "Center was created!"
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
            "centers" => $centers
        ], 200);

    }

    /**
    * @method GET
    * @param Array $payload
    */

    public function getVaccineCenters (Array $payload)
    {

      //
      $payload = (object) $payload;
    }

    /**
    * @method DELETE
    * @param Request $request
    */
    public function removeCenter(Request $request) {
        $request->validate([
            'center_id' => "required|integer"
        ]);

        $center = (object) $request->only('center_id');

        $center = Center::where('id', $center->center_id)->first();

        if($center != null) {
            $center->delete();

            return response()->json([
                "success" => "Center was deleted"
            ], 200);
        }

        return response()->json([
            "error" => "Center does not exists"
        ], 401);
    }
}
