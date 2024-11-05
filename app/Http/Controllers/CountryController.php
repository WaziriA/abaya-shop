<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CountryController extends Controller
{
    //
    public function getCountries()
    {
        // Fetch countries from the REST Countries API
        $response = Http::get('https://restcountries.com/v3.1/all');

        // Check if the response was successful
        if ($response->successful()) {
            // Extract country names
            $countries = $response->json();
            $countryNames = array_map(fn($country) => $country['name']['common'], $countries);

            // Pass country names to the view
            return view('your-view-name', ['countries' => $countryNames]);
        }

        return back()->with('error', 'Could not fetch country data');
    }
}
