<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Feedback;
use Illuminate\Support\Facades\Hash;

class CustomerprofileController extends Controller
{
    //
    public function index(){
        $user = Auth::user();
        
        // Apply eager loading (with) here while fetching orders
        $orders = $user->orders()->with(['products', 'shipping'])->get();
        
        return view('store.account.index', compact('user', 'orders'));
    }

    
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'user_id' => 'required|exists:users,id',
            
            'comment' => 'required|string',
        ]);

        // Create the feedback
        Feedback::create([
            'order_id' => $request->order_id,
            'user_id' => $request->user_id,
            
            'comment' => $request->comment,
        ]);

        // Redirect back or to a specific page
        return redirect()->back()->with('success', 'Feedback submitted successfully!');
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
