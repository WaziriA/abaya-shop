<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomeCarousel;
use App\Models\Product;

class HomeController extends Controller
{
    //
    public function index(){
        $carousels = HomeCarousel::all(); // Fetch all carousel items from the database
        $products = Product::with('category')->get(); 
        $newProducts = $products->where('status', 'new');
        $popularProducts = $products->where('status', 'pupular');
        $trendingProducts = $products->where('status', 'trending');
        return view('store.home-page', compact('carousels', 'products', 'newProducts',  'popularProducts', 'trendingProducts'));
       
    }

    public function addToCart(Request $request, $productId) {
        $product = Product::find($productId);
    
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found.'], 404);
        }
    
        $cart = session()->get('cart', []);
        
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                'name' => $product->name,
                'quantity' => 1,
                'price' => $product->price,
                'image' => $product->image,
            ];
        }
    
        session()->put('cart', $cart);
    
        return response()->json(['success' => true, 'message' => 'Product added to cart!']);
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
