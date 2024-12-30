<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Str;
use App\Notifications\CouponAssigned; // Make sure this line is included
use App\Models\Coupon;
use App\Models\User;

class CouponController extends Controller
{
    //
    public function index()
    {
        $coupons = Coupon::with('users')->get();
        $customers = User::where('role', 'customer')->get();
        return view('admin.coupon.index', compact('coupons', 'customers'));
    }

    public function create()
    {
        $users = User::all();
        return view('admin.coupons.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:fixed,percentage',
            'discount_value' => 'required|numeric|min:0',
            'expires_at' => 'required|date',
        ]);

        // Create the coupon
        $coupon = Coupon::create($request->only('name', 'type', 'discount_value', 'expires_at'));

        // Assign users if any are selected
        if ($request->filled('user_ids')) {
            $coupon->users()->attach($request->input('user_ids'));
        }

        // Send notification to assigned users
        foreach ($request->input('user_ids') as $userId) {
            $user = User::find($userId);
            $user->notify(new CouponAssigned($coupon));
        }

        return redirect()->back()->with('success', 'Coupon created' . ($request->filled('user_ids') ? ' and assigned to users' : '') . ' successfully.');
    }

    public function show($id)
    {
        $coupon = Coupon::with('users')->findOrFail($id);
        return view('admin.coupon.view-coupon', compact('coupon'));
    }

    public function update(Request $request, $id)
{
    try {
        $coupon = Coupon::findOrFail($id);

        // Define validation rules
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
            'type' => 'nullable|in:fixed,percentage',
            'discount_value' => 'nullable|numeric|min:0',
            'expires_at' => 'nullable|date',
        ]);

        // Update only the fields that were provided in the request
        foreach ($validatedData as $key => $value) {
            if ($value !== null) {
                $coupon->$key = $value;
            }
        }

        // Save the updated coupon
        $coupon->save();

        // Handle user assignment if any are selected
        // If `user_ids` is empty, detach all users
        if ($request->filled('user_ids')) {
            $coupon->users()->sync($request->input('user_ids')); // Sync selected users

            foreach ($request->input('user_ids') as $userId) {
                $user = User::find($userId);
                $user->notify(new CouponAssigned($coupon));
            }
        } 
        else {
            $coupon->users()->detach(); // Unassign all users
        }

        
        return redirect()->back()->with('success', 'The coupon information has been updated successfully');
    } catch (\Exception $e) {
        // Handle the error and return a message
        return redirect()->back()->with('error', 'An error occurred while updating the coupon: ' . $e->getMessage());
    }
}

       public function edit($id)
{
       $coupon = Coupon::findOrFail($id);
       $users = User::all(); // Fetch all users for the assignment

              return view('admin.coupon.edit', compact('coupon', 'users'));
}

public function softDelete($id)
{
    try {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        return redirect()->back()->with('success', 'Coupon has been deleted successfully.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'An error occurred while deleting the coupon: ' . $e->getMessage());
    }
}

public function trashed()
{
    $trashedCoupons = Coupon::onlyTrashed()->get(); // Retrieve all soft-deleted coupons
    return view('admin.coupon.deleted', compact('trashedCoupons')); // Return a view to list trashed coupons
}

public function restore($id)
{
    try {
        $coupon = Coupon::withTrashed()->findOrFail($id); // Retrieve the soft-deleted coupon
        $coupon->restore(); // Restore the coupon

        return redirect()->back()->with('success', 'Coupon restored successfully.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'An error occurred while restoring the coupon: ' . $e->getMessage());
    }

}

public function expiredCoupons()
{
    // Retrieve expired coupons
    $expiredCoupons = Coupon::with('users')->where('expires_at', '<', now())->get();

    return view('admin.coupon.expired', compact('expiredCoupons'));
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