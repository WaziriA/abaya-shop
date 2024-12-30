<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Review;
use session;

class ProductController extends Controller
{
    //
    public function index(){

    $categories = Category::all();
    $products = Product::with('category')->get();

        return view('admin/products/index', compact('categories', 'products'));
    }
    public function store(Request $request){
        $validatedData = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'category_id' => 'required|integer|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'brand' => 'required|string|max:255',
            'price_usd' => 'required|numeric', // Price in USD is mandatory
            'price_gbp' => 'nullable|numeric', // GBP price is optional
            'price_eur' => 'nullable|numeric', // EUR price is optional
            'price_aed' => 'nullable|numeric', // AED price is optional
            'sku' => 'required|string|max:50|unique:products',
            'stock' => 'required|integer',
            'availability_status' => 'required|string|in:in-stock,out-of-stock,low-stock',
            'color' => 'nullable|string|max:50',
            'size' => 'nullable|string|max:50',
            'status' => 'required|string|in:new,trending,sold-out,sale,hot,popular',
            'location' => 'nullable|string|max:255',
        ]);

        // Save image file
        if($request->hasFile('image')){
            $imagePath = $request->file('image')->store('/products', 'public');
            $validatedData['image'] = $imagePath;
        }
            //dd($validatedData);
        Product::create($validatedData);

        return redirect()->back()->with('success', 'Product added successfully!');
    }


    public function update(Request $request, $id)
{
    try {
        $product = Product::findOrFail($id);

        // Define validation rules
$validatedData = $request->validate([
    'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    'category_id' => 'nullable|integer|exists:categories,id',
    'name' => 'nullable|string|max:255',
    'description' => 'nullable|string',
    'brand' => 'nullable|string|max:255',
    'price_usd' => 'nullable|numeric', // Price in USD
    'price_gbp' => 'nullable|numeric', // Price in GBP
    'price_eur' => 'nullable|numeric', // Price in EUR
    'price_aed' => 'nullable|numeric', // Price in AED
    'sku' => 'nullable|string|max:50|unique:products,sku,' . $product->id, // Exclude current product's ID for unique validation
    'stock' => 'nullable|integer',
    'availability_status' => 'nullable|string|in:in-stock,out-of-stock,low-stock',
    'color' => 'nullable|string|max:50',
    'size' => 'nullable|string|max:50',
    'status' => 'nullable|string|in:new,trending,sold-out,sale,hot,popular',
    'location' => 'nullable|string|max:255',
]);

        // Save image file if provided
        if ($request->hasFile('image')) {
            // Delete the old image if exists
            if ($product->image) {
                Storage::delete($product->image);
            }

            $imagePath = $request->file('image')->store('images/products', 'public');
            $validatedData['image'] = $imagePath; // Store the new image path
        }

        // Update only the fields that were provided in the request
        foreach ($validatedData as $key => $value) {
            if ($value !== null) {
                $product->$key = $value;
            }
        }

        // Save the updated product
        $product->save();

        return redirect()->back()->with('success', 'The product information has been updated successfully');
    } catch (\Exception $e) {
        // Handle the error and return a message
        return redirect()->back()->with('error', 'An error occurred while updating the product: ' . $e->getMessage());
    }
}

 // Hard delete a product (permanently delete)
 public function forceDelete($id)
 {
     $product = Product::withTrashed()->findOrFail($id);

     // Delete the image if it exists
     if ($product->image) {
         Storage::delete($product->image);
     }

     $product->forceDelete();

     return redirect()->back()->with('success', 'Product permanently deleted!');
 }


 // Soft delete a product
public function softDelete($id)
{
    $product = Product::findOrFail($id);
    $product->delete();

    return redirect()->back()->with('success', 'Product moved to trash!');
}


 // Restore a soft deleted product
 public function restore($id)
 {
     $product = Product::withTrashed()->findOrFail($id);
     $product->restore();

     return redirect()->back()->with('success', 'Product restored successfully!');
 }


 // Show deleted products
 public function deletedItems()
 {
     $deletedProducts = Product::onlyTrashed()->with('category')->get();

     return view('admin/products/deleted-products', compact('deletedProducts'));
 }

 public function getReviews()
 {
     $reviews = Review::with(['user', 'product'])->get();
 
     return view('admin.products.reviews', compact('reviews'));
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
