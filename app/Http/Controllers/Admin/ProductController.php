<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
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
            'category_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'brand' => 'required|string|max:255',
            'price' => 'required|numeric',
            'sku' => 'required|string|max:50|unique:products',
            'stock' => 'required|integer',
            'availability_status' => 'required|string|in:in-stock,out-of-stock,low-stock',
            'color' => 'nullable|string|max:50',
            'size' => 'nullable|string|max:50',
            'status' => 'required|string|in:new,trending,sold-out,sale,hot,pupular',
            'location' => 'nullable|string|max:255'
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
            'category_id' => 'nullable|integer',
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'brand' => 'nullable|string|max:255',
            'price' => 'nullable|numeric',
            'sku' => 'nullable|string|max:50|unique:products,sku,' . $product->id,
            'stock' => 'nullable|integer',
            'availability_status' => 'nullable|string|in:in-stock,out-of-stock,low-stock',
            'color' => 'nullable|string|max:50',
            'size' => 'nullable|string|max:50',
            'status' => 'nullable|string|in:new,trending,sold-out,sale,hot,popular',
            'location' => 'nullable|string|max:255'
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
}
