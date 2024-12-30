<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Cart;

class LoginController extends Controller
{
    //
    public function showLoginForm()
    {
        return view('auth.login'); // Optional if using a separate view
    }

    /*public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        if (Auth::attempt($request->only('email', 'password'))) {
            // Retrieve the authenticated user's role
            $userCart = Cart::where('user_id', auth()->id())->first();

        if ($userCart) {
            // Merge session cart with the database cart
            $sessionCart = session()->get('cart', []);
            $cart = array_merge($sessionCart, $userCart->cart_data);
            
            // Save merged cart back into session
            session()->put('cart', $cart);
        }
            $userRole = Auth::user()->role;
              
            // Redirect based on the role
            if (in_array($userRole, ['owner', 'staff'])) {
                return redirect()->route('dashboard.index')->with('success', 'you login successfully'); // Redirect to dashboard for owner and staff
            } else {
                return redirect()->route('home.index')->with('success', 'you login successfully');; // Redirect to home for customers
            }
        }
    
        // If authentication fails, return with an error
        return back()->with('error', 'User with this credentials not found');
            
        
    }*/

    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($request->only('email', 'password'))) {
        // Merge session cart with the database cart if available
        $userCart = Cart::where('user_id', auth()->id())->first();
        if ($userCart) {
            $sessionCart = session()->get('cart', []);
            $cart = array_merge($sessionCart, $userCart->cart_data);
            session()->put('cart', $cart);
        }

        $userRole = Auth::user()->role;

        // Redirect based on role
        if (in_array($userRole, ['owner', 'staff'])) {
            return redirect()->route('dashboard.index')->with('success', 'You logged in successfully!');
        } else {
            return redirect()->route('home.index')->with('success', 'You logged in successfully!');
        }
    }

    // If login fails, return with error
    return back()->with('error', 'User with these credentials not found');
}


public function logout(Request $request)
{
    // Clear the cart session if applicable
    session()->forget('cart');

    // Logout the user
    Auth::logout();

    // Flash a success message to the session
    session()->flash('success', 'You have successfully logged out.');

    // Redirect to the home page or wherever you want
    return redirect('/')->with('success', 'You have successfully logged out.');
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
