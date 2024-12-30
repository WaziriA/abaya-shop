<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Agent;
use App\Models\Product;
use App\Models\Transpoter;
use App\Models\DestinationCountry;
use App\Models\ShipmentMethod;

class CheckOutController extends Controller
{
    
    public function index()
    {
        // Check if user is authenticated
    if (!auth()->check()) {
        return redirect()->route('login'); // Redirect to login page if not authenticated
    }

      $ip = request()->ip(); // Use the user's IP address
    $location = Http::get("http://ip-api.com/json/{$ip}")->json();

    // Determine the currency based on the country
    $country = $location['country'] ?? 'USA'; // Default to USA if country is not detected
  //  $country = 'United Kingdom';
    $currency = match ($country) {
        'United Arab Emirates' => 'AED',
        'United Kingdom' => 'GBP',
        'Germany', 'France', 'Spain' => 'EUR', // Example European countries
        'USA', 'United States' => 'USD',
        default => 'USD', // Default currency
    };

    // Fetch products with the corresponding price column
    $price_column = match ($currency) {
        'AED' => 'price_aed',
        'GBP' => 'price_gbp',
        'EUR' => 'price_eur',
        default => 'price_usd',
    };

         // Fetch all carousel items from the database
        $products = Product::with('category', 'orders')->get()->map(function ($product) use ($price_column) {
            $product->price = $product->$price_column; // Dynamically set the price attribute
            return $product;
        });

        $agents = Agent::all();
        $transpoters = Transpoter::all();
        $countries = DestinationCountry::all();
        $shipment_methods = ShipmentMethod::all();
        
        // Retrieve cart data and shipping info from session
        $cart = session()->get('cart', []);
        $total = session()->get('cart_total', 0); // Total from session
        $shipping_cost = session()->get('shipping_cost', 0); // Shipping cost from session

        if (!is_numeric($total) || $total <= 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty or invalid. Please review your cart.');
        }

        
    
        // Retrieve selected shipping agent, shipment method, and country from session
        $transpoter_id = session()->get('transpoter_id');
        $shipment_method_id = session()->get('shipment_method_id');
        $country_id = session()->get('country_id');
        
        session(['currency' => $currency]);
        return view('store.check-out.index', compact(
            'cart', 'agents', 'transpoters', 'countries', 'shipment_methods', 'currency',
            'total', 'shipping_cost', 'transpoter_id', 'shipment_method_id', 'country_id'
        ));
    }
    


   /* public function getAgentDetails($transpoter_id)
{
    // Retrieve the agent details related to the selected transporter
    $agents = Agent::where('transpoter_id', $transpoter_id)->get(['shipment_method', 'destination_country']);

    // Return the data as a JSON response
    return response()->json($agents);
}*/

/*public function getAgentDetails($transpoter_id)
{
    $agents = Agent::where('transpoter_id', $transpoter_id)
        ->get(['transpoter_id', 'shipment_method_id', 'destination_country_id', 'from', 'to', 'cost']);

    return response()->json($agents);
}*/

public function getAgentDetails($transpoter_id)
{
    try {
        // Fetch the agents and their associated shipment methods and destination countries for the selected transporter
        $agents = Agent::where('transpoter_id', $transpoter_id)
            ->with(['shipmentMethod:id,method_name', 'destinationCountry:id,country_name'])  // Include the 'method_name' and 'country_name' fields
            ->get(['transpoter_id', 'shipment_method_id', 'destination_country_id', 'from', 'to', 'cost']);

        // Return the data as a JSON response
        return response()->json($agents);
    } catch (\Exception $e) {
        // Log the error
        \Log::error('Error fetching agent details: ' . $e->getMessage());
        return response()->json(['error' => 'An error occurred while fetching agent details.'], 500);
    }
}


    // Handle AJAX for shipment methods based on selected transporter
    public function getShipmentMethods(Request $request)
    {
        $shipmentMethods = ShipmentMethod::where('transpoter_id', $request->transpoter_id)->get();
        return response()->json($shipmentMethods);
    }

    // Handle AJAX for destination countries based on selected transporter
    public function getDestinationCountries(Request $request)
    {
        $countries = DestinationCountry::where('transpoter_id', $request->transpoter_id)->get();
        return response()->json($countries);
    }

    // The method to calculate the shipping cost based on user's input
    public function calculateShippingCost(Request $request)
    {
        // Extract input
        $transpoter_id = $request->transpoter_id;
        $shipment_method_id = $request->shipment_method_id;
        $destination_country_id = $request->destination_country_id;
        $input_value = $request->input_value;

        // Query the agent table for the matching rows
        $agent = Agent::where('transpoter_id', $transpoter_id)
                      ->where('shipment_method_id', $shipment_method_id)
                      ->where('destination_country_id', $destination_country_id)
                      ->where('from', '<=', $input_value)
                      ->where('to', '>=', $input_value)
                      ->first(); // Get the first match

        if ($agent) {
            return response()->json(['cost' => $agent->cost]);
        } else {
            return response()->json(['cost' => 0]); // No match found
        }
    }

}
