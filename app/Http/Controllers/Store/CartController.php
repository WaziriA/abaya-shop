<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Coupon;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    //
    public function index()
    {
        // Retrieve cart items from session
        $cart = Session::get('cart', []);
        
        // Calculate subtotal and total
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        $total = $subtotal; // Add shipping or taxes here if needed

        return view('store.cart.index', compact('cart', 'subtotal', 'total'));
    }

    
    public function removeProductFromCart(Request $request) {
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



   public function update(Request $request)
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
}


    
}
