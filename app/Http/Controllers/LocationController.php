<?php

namespace VaccineCard\Http\Controllers;

use VaccineCard\Models\Country;
use VaccineCard\Models\State;

class LocationController extends Controller
{
    /**
     * @method POST
     */
    public function getCountries()
    {
        $countries = Country::get();
        return response()->json([
            'countries' => $countries,
        ], 200);
    }

    /**
     * @method GET
     * @param int $country_id
     */
    public function getCountry(int $country_id)
    {
        $country = Country::find($country_id);

        return response()->json([
            'country' => $country,
        ], 200);
    }

    /**
     * @method GET
     * @param int $country_id
     */
    public function getStates(int $country_id)
    {
        $statesByCountry = Country::find($country_id)->states;

        return response()->json([
            'states' => $statesByCountry,
        ], 200);
    }

    /**
     * @method GET
     * @param int $state_id
     */
    public function getState(int $state_id)
    {
        $statesById = State::where('id', $state_id)
            ->first();

        return response()->json([
            'state' => $statesById,
        ], 200);
    }
}
