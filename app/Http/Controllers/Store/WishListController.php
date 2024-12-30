<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http; // Correctly import the Http facade
use App\Models\Wishlist;
use App\Models\Product;

class WishListController extends Controller
{
    //
    

public function index()
{
    // Fetch user location data
    $ip = request()->ip(); // Get user's IP address
    $location = Http::get("http://ip-api.com/json/{$ip}")->json();

    // Determine the currency based on the country
    $country = $location['country'] ?? 'USA'; // Default to USA if country is not detected
    $currency = match ($country) {
        'United Arab Emirates' => 'AED',
        'United Kingdom' => 'GBP',
        'Germany', 'France', 'Spain' => 'EUR',
        'USA', 'United States' => 'USD',
        default => 'USD',
    };

    // Fetch the correct price column based on the currency
    $price_column = match ($currency) {
        'AED' => 'price_aed',
        'GBP' => 'price_gbp',
        'EUR' => 'price_eur',
        default => 'price_usd',
    };

    if (auth()->check()) {
        // Fetch wishlist items for authenticated users with the correct price
        $wishlistItems = auth()->user()->wishlists()->with('product')->get()->map(function ($item) use ($price_column) {
            if ($item->product) {
                $item->product->price = $item->product->$price_column;
            }
            return $item;
        });
    } else {
        // Fetch wishlist items from the session for unauthenticated users
        $wishlistItems = collect(session()->get('wishlist', []))->map(function ($item) use ($price_column) {
            if (isset($item['product'])) {
                $item['product']['price'] = $item['product'][$price_column] ?? 0;
            }
            return $item;
        });
    }

    return view('store.wishlist.index', compact('wishlistItems', 'currency'));
}


    /* public function addToWishlist(Request $request)
{
    $productId = $request->input('id');
    
    // Log the incoming request
    \Log::info('Wishlist request received for product ID: ' . $productId);
    
    // Check if the user is authenticated
    if (auth()->check()) {
        try {
            // Add item to the wishlist in the database for authenticated users
            $wishlist = new Wishlist();
            $wishlist->product_id = $productId;
            $wishlist->user_id = auth()->id();
            $wishlist->save();
    
            // Log successful operation
            \Log::info('Item added to wishlist for user: ' . auth()->id());
    
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error adding to wishlist: ' . $e->getMessage());
    
            return response()->json(['success' => false, 'message' => 'Failed to add item to wishlist.']);
        }
    } else {
        // Return JSON response for unauthenticated users
        return response()->json(['success' => false, 'message' => 'User not authenticated. Please log in.']);
    }
}*/
/*public function addToWishlist(Request $request, $productId)
    {
        $productId = $request->input('id');

        if (auth()->check()) {
            // Check if the product is already in the wishlist for this user
            $exists = Wishlist::where('user_id', auth()->id())
                              ->where('product_id', $productId)
                              ->exists();

            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'This product is already in your wishlist.'
                ]);
            }

            // Add the product to the wishlist
            try {
                Wishlist::create([
                    'user_id' => auth()->id(),
                    'product_id' => $productId,
                ]);

                return response()->json(['success' => true, 'message' => 'Product added to wishlist.']);
            } catch (\Exception $e) {
                \Log::error('Error adding to wishlist: ' . $e->getMessage());

                return response()->json([
                    'success' => false,
                    'message' => 'Failed to add product to wishlist.'
                ]);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'You need to log in to add items to your wishlist.']);
        }
    }

}*/

  public function addToWishlist($productId)
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // Get the authenticated user's ID
            $userId = Auth::id();
            
            // Check if the product exists in the database
            $product = Product::find($productId);
            if ($product) {
                // Check if the product is already in the user's wishlist
                $existingWishlistItem = WishList::where('user_id', $userId)
                                                ->where('product_id', $productId)
                                                ->first();

                if ($existingWishlistItem) {
                    // If the product is already in the wishlist, redirect back with a message
                    return redirect()->back()->with('success', 'Product is already in your wishlist.');
                }

                // Add the product to the wishlist
                WishList::create([
                    'user_id' => $userId,
                    'product_id' => $productId
                ]);

                return redirect()->back()->with('success', 'Product added to your wishlist!');
            }

            return redirect()->back()->with('error', 'Product not found.');
        }

        // If the user is not authenticated, return a message
        return redirect()->route('login')->with('error', 'Please log in to add to your wishlist.');
    }

    public function destroy($id)
{
    // Check if the user is authenticated
    if (auth()->check()) {
        // Find the wishlist item by ID for the authenticated user
        $wishlistItem = WishList::where('id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if ($wishlistItem) {
            $wishlistItem->delete(); // Delete the item from the database
            return redirect()->back()->with('success', 'Item removed from wishlist successfully.');
        } else {
            return redirect()->back()->with('error', 'Item not found or you are not authorized.');
        }
    }

    // If the user is not authenticated, redirect with an error message
    return redirect()->back()->with('error', 'You must be logged in to manage your wishlist.');
}

}

