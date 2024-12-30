<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    //
    public function index(){
        $user = Auth::user(); // Get the currently authenticated user

        return view('admin/profile/view-profile/index', compact('user'));
    }
    public function update(Request $request)
    {
        try {
            $user = Auth::user(); // Get the currently authenticated user

            // Define validation rules
            $validatedData = $request->validate([
                'name' => 'nullable|string|max:255',
                'email' => 'nullable|email|max:255|unique:users,email,' . $user->id,
                'phone_no' => 'nullable|string|max:15',
                'phone_no2' => 'nullable|string|max:15',
                'gender' => 'nullable|string|in:male,female,other',
                'country' => 'nullable|string|max:255',
                
                'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // for photo
            ]);

            // Handle photo upload if provided
            if ($request->hasFile('photo')) {
                // Delete the old photo if exists
                if ($user->photo) {
                    Storage::delete('public/' . $user->photo);
                }

                // Store the new photo
                $photoPath = $request->file('photo')->store('images/users', 'public');
                $validatedData['photo'] = $photoPath; // Store the new photo path
            }

            // Update only the fields that were provided in the request
            foreach ($validatedData as $key => $value) {
                if ($value !== null) {
                    $user->$key = $value;
                }
            }

            // Save the updated user
            $user->save();

            return back()->with('success', 'Profile updated successfully');
        } catch (\Exception $e) {
            // Handle the error and return a message
            return back()->with('error', 'An error occurred while updating the user: ' . $e->getMessage());
        }
    }

    public function changePasswordForm()
    {
        return view('admin.profile.change-password.index');
    }

     // Handle the Change Password Request
     public function changePassword(Request $request)
     {
         // Validate the password change request
         $validatedData = $request->validate([
             'current_password' => 'required|string|min:8',
             'new_password' => 'required|string|min:8|confirmed', // 'confirmed' will check if new_password_confirmation matches
         ]);
 
         $user = Auth::user(); // Get the currently authenticated user
 
         // Check if the current password is correct
         if (!Hash::check($validatedData['current_password'], $user->password)) {
             throw ValidationException::withMessages([
                 'current_password' => ['The provided password does not match our records.'],
             ]);
         }
 
         // Update the user's password
         $user->password = Hash::make($validatedData['new_password']);
         $user->save();
 
         return back()->with('success', 'Password changed successfully.');
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
