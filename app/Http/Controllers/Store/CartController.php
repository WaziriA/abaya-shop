<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Product;
use App\Models\Coupon;
use App\Models\Agent;
use App\Models\Transpoter;
use App\Models\DestinationCountry;
use App\Models\ShipmentMethod;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    //
    public function index(Request $request)
    {
              // Fetch user location data
    $ip = request()->ip(); // Use the user's IP address
    $location = Http::get("http://ip-api.com/json/{$ip}")->json();

    // Determine the currency based on the country
    $country = $location['country'] ?? 'USA'; // Default to USA if country is not detected
    //$country = 'United Kingdom';
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

        // Retrieve cart items from session
        $cart = Session::get('cart', []);
        
        // Calculate subtotal and total
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        $total = $subtotal; // Add shipping or taxes here if needed

        // Update session values
        Session::put('cart_total', $total);

        $transpoters = Transpoter::all();
        $shipment_methods = ShipmentMethod::all();
        $countries = DestinationCountry::all();

        $transpoter_id = $request->input('transpoter_id');
        $shipment_method_id = $request->input('shipment_method_id');
        $country_id = $request->input('country_id');
        session()->put('shipping_details', [
            'transpoter_id' => $transpoter_id,
            'shipment_method_id' => $shipment_method_id,
            'country_id' => $country_id,
        ]);
        return view('store.cart.index', compact('cart', 'subtotal', 'total', 'countries','shipment_methods', 'transpoters','currency' ));
    }

    
    public function removeProductFromCart(Request $request) {
        if ($request->ajax()) {
            $productId = $request->id;
    
            // Retrieve the cart from session
            $cart = session()->get('cart', []);
    
            // Check if the product exists in the cart and remove it
            if (isset($cart[$productId])) {
                unset($cart[$productId]);
                session()->put('cart', $cart);
            }
    
            // Recalculate the subtotal (total product price)
            $subtotal = 0;
            foreach ($cart as $item) {
                $subtotal += $item['quantity'] * $item['price'];
            }
    
            // Clear the shipping cost if the cart is empty
            $shipping_cost = 0;
    
            // Check if there are any items in the cart and if a shipping cost needs to be recalculated
            if (!empty($cart)) {
                $shipping_cost = session()->get('shipping_cost', 0); // Get the current shipping cost
            }
    
            // Recalculate the total after removing the product and adjusting shipping cost
            $total = $subtotal + $shipping_cost;
    
            // Update session with the recalculated values
            session()->put('cart_total', $total);
            session()->put('shipping_cost', $shipping_cost);
    
            // Return response with updated cart, total, and item count
            return response()->json([
                'success' => true,
                'cart' => $cart,
                'total' => $total,
                'shipping_cost' => $shipping_cost,
                'itemCount' => count($cart),
            ]);
        }
    }
    

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string'
        ]);

        $coupon = Coupon::where('code', $request->code)
            ->where('expires_at', '>', now())
            ->first();

        if (!$coupon) {
            return back()->withErrors(['code' => 'Invalid or expired coupon code.']);
        }

        $cart = Session::get('cart', []);
        $subtotal = 0;

        foreach ($cart as $productId => $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $discount = 0;

        if ($coupon->type === 'percentage') {
            $discount = ($coupon->discount_value / 100) * $subtotal;
        } elseif ($coupon->type === 'fixed') {
            $discount = $coupon->discount_value;
        }

        $total = $subtotal - $discount;

        // Update cart session with new total
        Session::put('coupon', [
            'code' => $code,
            'discount' => $discount
        ]);

        return redirect()->route('cart.index')->with(['subtotal' => $subtotal, 'total' => $total]);
    }

    public function calculateShippingCost(Request $request)
{
    $transpoter_id = $request->input('transpoter_id');
    $shipment_method_id = $request->input('shipment_method_id');
    $country_id = $request->input('country_id');
    $cart = session()->get('cart', []);

    $subtotal = array_reduce($cart, function ($carry, $item) {
        return $carry + ($item['price'] * $item['quantity']);
    }, 0);

    $shipping_cost = 0;

    if ($transpoter_id && $shipment_method_id && $country_id) {
        $agent = Agent::where('transpoter_id', $transpoter_id)
            ->where('shipment_method_id', $shipment_method_id)
            ->where('destination_country_id', $country_id)
            ->where('from', '<=', $subtotal)
            ->where('to', '>=', $subtotal)
            ->first();

        if ($agent) {
            $shipping_cost = $agent->cost;
        }
    }

    $total = $subtotal + $shipping_cost;

    session()->put('shipping_details', [
        'transpoter_id' => $transpoter_id,
        'shipment_method_id' => $shipment_method_id,
        'country_id' => $country_id,
    ]);

    session()->put('shipping_cost', $shipping_cost);
    session()->put('cart_total', $total);

    return response()->json([
        'success' => true,
        'shipping_cost' => $shipping_cost,
        'total' => $total,
    ]);
}

    public function update(Request $request) 
    {
        // Retrieve the cart from the session
        $cart = session()->get('cart', []);
    
        // Retrieve the quantities input
        $quantities = $request->input('quantities', []);
    
        // Update quantities in the cart
        foreach ($cart as $productId => &$item) {
            if (isset($quantities[$productId])) {
                $item['quantity'] = max(1, (int) $quantities[$productId]);
            }
        }
    
        // Calculate subtotal
        $subtotal = array_reduce($cart, function($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);
    
        // Initialize shipping details
        $transpoter_id = $request->input('transpoter_id');
        $shipment_method_id = $request->input('shipment_method_id');
        $country_id = $request->input('country_id');
        $shipping_cost = 0;
    
        // Check if the user selected "pickup"
        if ($transpoter_id == 'pickup') {
            $transpoter_id = null;
            $shipment_method_id = 'N/A';
            $country_id = 'N/A';
        } else {
            // Calculate shipping cost if a shipping agent is selected
            if ($transpoter_id && $shipment_method_id && $country_id) {
                $agent = Agent::where('transpoter_id', $transpoter_id)
                    ->where('shipment_method_id', $shipment_method_id)
                    ->where('destination_country_id', $country_id)
                    ->where('from', '<=', $subtotal)
                    ->where('to', '>=', $subtotal)
                    ->first();
    
                if ($agent) {
                    $shipping_cost = $agent->cost;
                }
            }
        }
    
        // Update the session
        session()->put('cart', $cart);
        session()->put('cart_total', $subtotal + $shipping_cost);
        session()->put('shipping_cost', $shipping_cost);
        session()->put('transpoter_id', $transpoter_id);
        session()->put('shipment_method_id', $shipment_method_id);
        session()->put('country_id', $country_id);
        
        return redirect()->back()->with('success', 'Cart updated successfully');
    }
    
   /* public function update(Request $request)
{
    // Retrieve the cart from the session
    $cart = session()->get('cart', []);

    // Retrieve the quantities input
    $quantities = $request->input('quantities', []);

    // Update quantities in the cart
    foreach ($cart as $productId => &$item) {
        if (isset($quantities[$productId])) {
            $item['quantity'] = max(1, (int) $quantities[$productId]); // Ensure quantity is at least 1
        }
    }

    // Calculate subtotal based on updated quantities
    $subtotal = array_reduce($cart, function($carry, $item) {
        return $carry + ($item['price'] * $item['quantity']);
    }, 0);

    // Initialize variables for shipping details
    $transpoter_id = $request->input('transpoter_id');
    $shipment_method_id = $request->input('shipment_method_id');
    $country_id = $request->input('country_id');
    $shipping_cost = 0;

    // Calculate shipping cost based on the selected agent and product price range
    if ($transpoter_id && $shipment_method_id && $country_id) {
        $agent = Agent::where('transpoter_id', $transpoter_id)
            ->where('shipment_method_id', $shipment_method_id)
            ->where('destination_country_id', $country_id)
            ->where('from', '<=', $subtotal)
            ->where('to', '>=', $subtotal)
            ->first();

        // Additional check to confirm range and assign cost
        if ($agent && $subtotal >= $agent->from && $subtotal <= $agent->to) {
            $shipping_cost = $agent->cost;
        } else {
            // Logging for debugging if no matching agent found
            logger("No matching agent found within range for subtotal: $subtotal. Details - Transporter ID: $transpoter_id, Shipment Method ID: $shipment_method_id, Country ID: $country_id.");

            // Optional: Log all agents that match transporter, shipment method, and country
            $availableAgents = Agent::where('transpoter_id', $transpoter_id)
                ->where('shipment_method_id', $shipment_method_id)
                ->where('destination_country_id', $country_id)
                ->get();
            logger("Available agents for transporter/method/country: " . $availableAgents->toJson());
        }
    }

    // Calculate the total (subtotal + shipping cost)
    $total = $subtotal + $shipping_cost;

    // Update the session with the updated cart, shipping cost, and total
    session()->put('cart', $cart);
    session()->put('cart_total', $total);
    session()->put('shipping_cost', $shipping_cost);
    session()->put('transpoter_id', $transpoter_id);
    session()->put('shipment_method_id', $shipment_method_id);
    session()->put('country_id', $country_id);
    
    return redirect()->back()->with('success', 'Cart updated successfully');
}*/

public function getRelatedData(Request $request)
{
    $transpoter_id = $request->input('transpoter_id');
    
    // Get shipment methods and countries related to the selected transporter
    $agents = Agent::where('transpoter_id', $transpoter_id)->get();

    $shipment_methods = ShipmentMethod::whereIn('id', $agents->pluck('shipment_method_id')->unique())->get();
    $countries = DestinationCountry::whereIn('id', $agents->pluck('destination_country_id')->unique())->get();

    return response()->json([
        'shipment_methods' => $shipment_methods,
        'countries' => $countries
    ]);
}

    /*public function update(Request $request)
    {
        // Retrieve the cart from the session
        $cart = session()->get('cart', []);
    
        // Retrieve the quantities input
        $quantities = $request->input('quantities', []);
    
        // Update quantities in the cart
        foreach ($cart as $productId => &$item) {
            if (isset($quantities[$productId])) {
                $item['quantity'] = max(1, (int) $quantities[$productId]); // Ensure quantity is at least 1
            }
        }
    
        // Update shipping details
        $transpoter_id = $request->input('transpoter_id');
        $shipment_method_id = $request->input('shipment_method_id');
        $country_id = $request->input('country_id');
    
        $shipping_cost = 0;
    
        // Calculate shipping cost based on the selected agent
        if ($transpoter_id && $shipment_method_id && $country_id) {
            $agent = Agent::where('transpoter_id', $transpoter_id)
                ->where('shipment_method_id', $shipment_method_id)
                ->where('destination_country_id', $country_id)
                ->first();
    
            if ($agent) {
                $shipping_cost = $agent->cost;
            }
        }
    
        // Calculate subtotal based on updated quantities
        $subtotal = array_reduce($cart, function($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);
    
        // Calculate the total (subtotal + shipping cost)
        $total = $subtotal + $shipping_cost;
    
        // Update the session with the updated cart, shipping cost, and total
        session()->put('cart', $cart);
        session()->put('cart_total', $total);
        session()->put('shipping_cost', $shipping_cost);
    
        return redirect()->back()->with('success', 'Cart updated successfully');
    }*/
    
    

 /*  public function update(Request $request)
{
    // Validate the quantities
    $validatedData = $request->validate([
        'quantities.*' => 'required|integer|min:1', // Ensure each quantity is at least 1
    ]);

    // Retrieve the cart from the session
    $cart = Session::get('cart', []);

    // Update the cart with new quantities
    foreach ($validatedData['quantities'] as $productId => $quantity) {
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $quantity;
        }
    }

    // Save the updated cart back to the session
    Session::put('cart', $cart);

    // Recalculate the subtotal and total
    $subtotal = 0;
    foreach ($cart as $item) {
        $subtotal += $item['price'] * $item['quantity'];
    }
    $total = $subtotal; // Add shipping or taxes if needed

    // Instead of redirecting with the cart data, just redirect to the cart index
    return redirect()->back()->with('success', 'Your Cart has been updated successfully');
}*/


    
}
