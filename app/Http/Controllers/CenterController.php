<?php

namespace VaccineCard\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use VaccineCard\Models\Center;

class CenterController extends Controller
{
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

    public function getCenterByCategory(String $category)
    {
      
        $centers = Center::where('focus', $category)->get();
       
        return response()->json([
            "centers" => $centers
        ], 200);

    }

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
