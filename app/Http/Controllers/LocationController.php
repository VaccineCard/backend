<?php

namespace VaccineCard\Http\Controllers;

use Illuminate\Http\Request;
use VaccineCard\Models\Country;
use VaccineCard\Models\State;

class LocationController extends Controller
{
    public function getCountries () {
        $countries = Country::all();
        return response()->json([
            'countries' => $countries
        ], 200);
    }

    public function getCountry(int $country_id) {
        $country = Country::find($country_id);

        return response()->json([
            'country' => $country
        ], 200);
    }

    public function getStates (int $country_id) {
        $statesByCountry = State::where('country_id', $country_id)
                                ->get();
            
        return response()->json([
            'states' => $statesByCountry
        ],200);
    }

    public function getState (int $state_id) {
        $statesById = State::where('id', $state_id)
                    ->first();
        
        return response()->json([
            'state' => $statesById
        ],200);
    }
}
