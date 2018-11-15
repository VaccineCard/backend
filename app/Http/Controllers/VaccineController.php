<?php

namespace VaccineCard\Http\Controllers;

use Illuminate\Http\Request;
use VaccineCard\Models\Vaccine;

class VaccineController extends Controller
{
    public function getVaccines()
    {
        $vaccines = Vaccine::get();

        return response()->json([
            'vaccines' => $vaccines,
        ], 200);
    }

    public function getVaccineById(int $id)
    {
        $vaccine = Vaccine::where('id', $id)->first();

        return response()->json([
            'vaccine' => $vaccine,
        ], 200);
    }

    public function addVaccine(Request $request)
    {

        $request->validate([
            'vaccine_code' => 'required|unique:vaccines',
            'expire_at' => 'required',
            'name' => 'required',
        ]);

        $vaccine = $request->only('name', 'vaccine_code',
            'expire_at', 'type');

        dd($vaccine);
        Vaccine::create($vaccine);

        return response()->json([
            'vaccine' => 'Vaccina has created',
        ], 201);
    }

    public function updateVaccine(Request $request)
    {
        // Altera os campos setados
    }
}
