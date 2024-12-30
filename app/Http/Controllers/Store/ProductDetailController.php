<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Review;

class ProductDetailController extends Controller
{
    //
    public function index($id){
        $products = Product::all();
        $product = Product::findOrFail($id); // Get the specific product by ID
        return view('store/shop-single', compact('products', 'product'));
    }

    public function show($id)
    {
         // Fetch user location data based on IP
    $ip = request()->ip(); // Use the user's IP address
    $location = Http::get("http://ip-api.com/json/{$ip}")->json();

    // Determine the currency based on the country
    $country = $location['country'] ?? 'USA'; // Default to USA if country is not detected
    $currency = match ($country) {
        'United Arab Emirates' => 'AED',
        'United Kingdom' => 'GBP',
        'Germany', 'France', 'Spain' => 'EUR',
        'USA', 'United States' => 'USD',
        default => 'USD', // Default currency
    };

    // Fetch the corresponding price column
    $price_column = match ($currency) {
        'AED' => 'price_aed',
        'GBP' => 'price_gbp',
        'EUR' => 'price_eur',
        default => 'price_usd',
    };

    // Retrieve the product details
    $product = Product::findOrFail($id);
    $product->price = $product->$price_column; // Dynamically set the price

    $reviews = Review::where('product_id', $id)
    ->latest()
    ->take(5)
    ->get();

        $relatedProducts = Product::where('category_id', $product->category_id)
        ->where('id', '!=', $product->id) // Exclude the current product
        ->latest()
        ->take(12)
        ->get();
        $categories = Category::withCount('products')->get();

        $colorVariantProducts = Product::where('category_id', $product->category_id) 
    ->where('brand', $product->brand) // Same brand
    ->where('size', $product->size)   // Same size
    ->where('id', '!=', $product->id) // Exclude the current product
    ->where('color', '!=', $product->color) // Different color
    ->latest()
    ->take(12)
    ->get();
    $reviewCount = $product->reviews()->count(); // Get the total number of reviews

        return view('store.shop-single', compact('product','relatedProducts', 'categories', 'currency', 'colorVariantProducts', 'reviews', 'reviewCount')); // Pass it as $product to the view
    }

    public function store(Request $request, $productId)
    {
        $validatedData = $request->validate([
            'comment' => 'required|string|max:1000',
            'rating' => 'required|integer|between:1,5',
        ]);

        Review::create([
            'user_id' => Auth::check() ? Auth::id() : null, // Set to null if user is not authenticated
            'product_id' => $productId,
            'rating' => $validatedData['rating'],
            'comment' => $validatedData['comment'],
        ]);

        return back()->with('success', 'Thank you for your review!');
    }

    
private function getOS($userAgent)
{
    if (preg_match('/windows nt/i', $userAgent)) return 'Windows';
    if (preg_match('/macintosh|mac os x/i', $userAgent)) return 'Mac OS';
    if (preg_match('/linux/i', $userAgent)) return 'Linux';
    if (preg_match('/android/i', $userAgent)) return 'Android';
    if (preg_match('/iphone|ipad|ipod/i', $userAgent)) return 'iOS';
    return 'Unknown OS';
}

private function getBrowser($userAgent)
{
    if (preg_match('/firefox/i', $userAgent)) return 'Firefox';
    if (preg_match('/chrome/i', $userAgent)) return 'Chrome';
    if (preg_match('/safari/i', $userAgent)) return 'Safari';
    if (preg_match('/msie|trident/i', $userAgent)) return 'Internet Explorer';
    if (preg_match('/opera|opr/i', $userAgent)) return 'Opera';
    return 'Unknown Browser';
}

private function getDeviceBrand($userAgent)
{
    $brands = [
        'Samsung' => '/samsung/i',
        'Apple' => '/iphone|ipad|ipod|macintosh/i',
        'Huawei' => '/huawei/i',
        'Xiaomi' => '/xiaomi/i',
        'Oppo' => '/oppo/i',
        'Vivo' => '/vivo/i',
        'Google' => '/pixel/i',
        'OnePlus' => '/oneplus/i',
        'Sony' => '/sony/i',
        'Nokia' => '/nokia/i',
        'LG' => '/lg/i',
        'HTC' => '/htc/i',
        'Tecno' => '/tecno/i',
        'Infinix' => '/infinix/i',
        'HP' => '/hp|hewlett-packard|pavilion/i',  // Improved pattern for HP
        'Dell' => '/dell/i',
        'Lenovo' => '/lenovo/i',
        'Acer' => '/acer/i',
        'Asus' => '/asus/i',
        'Toshiba' => '/toshiba/i',
        'Microsoft' => '/microsoft/i',
        'Razer' => '/razer/i',
        'Alienware' => '/alienware/i', // For gaming computers
    ];

    foreach ($brands as $brand => $pattern) {
        if (preg_match($pattern, $userAgent)) {
            return $brand;
        }
    }

    return 'Unknown Brand';
}
}
