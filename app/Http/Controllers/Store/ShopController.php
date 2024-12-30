<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Product;
use App\Models\Category;

class ShopController extends Controller
{
    //
    public function index(){

        // Fetch user location data
   $ip = request()->ip(); // Use the user's IP address
    $location = Http::get("http://ip-api.com/json/{$ip}")->json();

    // Determine the currency based on the country
    $country = $location['country'] ?? 'USA'; // Default to USA if country is not detected*/
    //$country = 'United Kingdom'; // Change to 'Germany', 'France', 'Spain', 'United Arab Emirates', 'USA'
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

       
    $products = Product::with('category', 'orders')
    ->paginate(12); // Paginated query

$products->getCollection()->transform(function ($product) use ($price_column) {
    $product->price = $product->$price_column;
    return $product;
});


         
        $newProducts = $products->where('status', 'new');
        $popularProducts = $products->where('status', 'pupular');
        $trendingProducts = $products->where('status', 'trending');
        $categories = Category::all();
        $latestProducts = Product::latest()->take(6)->get();


        // Calculate subtotal from the session cart
        $cart = session()->get('cart', []);
        $subtotal = array_sum(array_map(function($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));
        return view('store/shop', compact('products', 'newProducts', 'popularProducts', 'trendingProducts', 'subtotal', 'categories','latestProducts','currency'));
    }
}
