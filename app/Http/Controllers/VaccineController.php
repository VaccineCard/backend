<?php

namespace VaccineCard\Http\Controllers;

use Illuminate\Http\Request;
use VaccineCard\Models\Vaccine;

class VaccineController extends Controller
{
    /**
     * @method GET
     * @param int $vaccine_id
     */
    public function getVaccine(int $vaccine_id)
    {
        $vaccine = Vaccine::where('id', $vaccine_id)->firstOrFail();

        return response()->json([
            "vaccine" => $vaccine,
        ], 200);
    }

    /**
     * @method GET
     * @param int $vaccine_id
     */

    public function getAllVaccines()
    {
        $vaccines = Vaccine::all();

        return response()->json([
            "vaccines" => $vaccines,
        ], 200);
    }

    /**
     * @method POST
     * @param Request $request
     */

    public function addNewVaccine(Request $request)
    {
        $request->validate([
            "name" => "required",
            "type" => "required",
            "vaccine_code" => "required|integer",
            "expire_at" => "required|date",
        ]);

        $vaccine = $request->only("name", "type", "vaccine_code", "expire_at");

        $new = Vaccine::firstOrNew($vaccine);
        if ($new['id']) {
            return response()->json([
                "warn" => "The vaccine exists!",
            ], 200);
        }
        $new->save();

        return response()->json([
            "success" => "The vaccine was created!",
        ], 201);

    }

    /**
     * @method DELETE
     * @param Request $request
     */
    public function removeVaccine(Request $request)
    {
        $request->validate([
            "vaccine_id" => "required|integer",
        ]);

        $vaccine = (object) $request->only("vaccine_id");
        if (Vaccine::where('id', $vaccine->vaccine_id)->delete()) {
            return response()->json([
                "success" => "The vaccine was deleted!",
            ], 200);
        }

        return response()->json([
            "error" => "The vaccine was not deleted!",
        ], 200);
    }
}
