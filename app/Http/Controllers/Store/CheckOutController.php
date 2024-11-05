<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckOutController extends Controller
{
    //
    public function index()
    {
        // Retrieve the cart from the session
        $cart = session()->get('cart', []);

        // Pass the cart data to the checkout view
        return view('store.check-out.index', compact('cart'));
    }
}
