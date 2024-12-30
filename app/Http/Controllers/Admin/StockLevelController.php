<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class StockLevelController extends Controller
{
    //
    public function index(){
        $products=Product::with('category')->get();

        return view('admin/products/stocks/stock', compact('products'));
    }

    // Method to update product stock
    public function updateStock(Request $request, $productId)
    {
        // Validate the incoming data
        $request->validate([
            'stock' => 'required|integer|min:1'
        ]);

        // Find the product by ID
        $product = Product::findOrFail($productId);

        // Update the product's stock
        $product->stock += $request->stock;
        $product->save();

        // Return response (could redirect back or return JSON)
        return redirect()->back()->with('success', 'Stock updated successfully!');
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
