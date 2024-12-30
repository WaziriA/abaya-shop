<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\HomeCarousel;
use App\Models\Product;
use App\Models\HomeTestimonial;

class HomeController extends Controller
{
    //
    public function index() {

         // Fetch user location data
   $ip = request()->ip(); // Use the user's IP address
    $location = Http::get("http://ip-api.com/json/{$ip}")->json();

    // Determine the currency based on the country
    $country = $location['country'] ?? 'USA'; // Default to USA if country is not detected*/
   // $country = 'United Kingdom'; // Change to 'Germany', 'France', 'Spain', 'United Arab Emirates', 'USA'
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

        $carousels = HomeCarousel::all(); // Fetch all carousel items from the database
        $products = Product::with('category', 'orders')->get()->map(function ($product) use ($price_column) {
            $product->price = $product->$price_column; // Dynamically set the price attribute
            return $product;

            
        });

        $newProducts = $products->where('status', 'new');
        $popularProducts = $products->where('status', 'pupular');
        $trendingProducts = $products->where('status', 'trending');
        $testimonials = HomeTestimonial::latest()->take(5)->get();
        $recentProducts = Product::latest()->take(8)->get();

        
        // Calculate subtotal from the session cart
        $cart = session()->get('cart', []);
        $subtotal = array_sum(array_map(function($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));
    
        return view('store.home-page', compact('carousels', 'products', 'newProducts', 'popularProducts', 'trendingProducts', 'subtotal', 'testimonials', 'recentProducts','currency'));
    }
    

    public function addToCart(Request $request, $productId) {
        $product = Product::find($productId);
    
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found.'], 404);
        }

          // Get the current currency for the user
   /* $ip = request()->ip(); // Get the user's IP address
    $location = Http::get("http://ip-api.com/json/{$ip}")->json();
    $country = $location['country'] ?? 'USA';*/
    $country = 'United Kingdom';
    $currency = match ($country) {
        'United Arab Emirates' => 'AED',
        'United Kingdom' => 'GBP',
        'Germany', 'France', 'Spain' => 'EUR',
        'USA', 'United States' => 'USD',
        default => 'USD',
    };

    $price_column = match ($currency) {
        'AED' => 'price_aed',
        'GBP' => 'price_gbp',
        'EUR' => 'price_eur',
        default => 'price_usd',
    };
    
        $cart = session()->get('cart', []);
        
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                'name' => $product->name,
                'quantity' => 1,
                'price' => $product->$price_column,
                'image' => $product->image,
            ];
        }
    
        session()->put('cart', $cart);
    
          // Add the cart count to the response
    return response()->json([
        'success' => true,
        'message' => 'Product added to cart!',
        'cart_count' => count($cart), // Return the updated count
    ]);
    }
    

    public function removeFromCart(Request $request) {
        if ($request->ajax()) {
            $productId = $request->id;
            $cart = session()->get('cart', []);
    
            if (isset($cart[$productId])) {
                unset($cart[$productId]);
                session()->put('cart', $cart);
            }
    
            // Calculate updated total and item count
            $total = array_sum(array_map(fn($item) => $item['quantity'] * $item['price'], $cart));
            $itemCount = count($cart);
    
            return response()->json([
                'success' => true,
                'cart' => $cart,
                'total' => $total,
                'itemCount' => $itemCount,
            ]);
        }
    }
    
}
