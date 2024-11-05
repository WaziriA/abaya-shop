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
}
