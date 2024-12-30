<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB; // Import Str facade
use Illuminate\Support\Facades\Log;
use App\Models\user;
use App\Notifications\UserCreatedNotification; // Import your notification class
use App\Notifications\UserActivities;
use Exception;
use session;

use Detection\MobileDetect; // Include MobileDetect

class UserController extends Controller
{
    //
    public function index()
    {

        $users = User::withTrashed()->get(); // Include soft-deleted users
        return view('admin.users.index', compact('users'));
    }


    //store
    public function store(Request $request)
    {
        try {
            // Define validation rules
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email',
                'gender' => 'nullable|in:male,female,other',
                'country' => 'nullable|string|max:100',
                'phone_no' => 'nullable|string|max:15',
                'phone_no2' => 'nullable|string|max:15',
                'role' => 'nullable|in:owner,staff,customer',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            // Handle photo upload if provided
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('images/users', 'public');
                $validatedData['photo'] = $photoPath; // Store the photo path
            }

            // Generate a random password
            $randomPassword = Str::random(10);

            // Hash the generated password before saving
            $validatedData['password'] = Hash::make($randomPassword);

            // Set IsActive to true by default
            $validatedData['IsActive'] = true;

            //dd($validatedData);

            // Create the new user
            $user = User::create($validatedData);

            // Prepare notification data with the user name and email
            $notificationData = [
                'title' => 'New User Created',
                'message' => 'A new user account has been created successfully with name: ' . $user->name . ' and email: ' . $user->email,
                'details' => [
                    'user_id' => $user->id,
                    'email' => $user->email,
                ],
            ];

            // Get device and browser details
        $detect = new \Detection\MobileDetect;
        $userAgent = request()->header('User-Agent');

        $notificationDetails = [
            'id' => Str::uuid(),
            'type' => UserActivities::class,
            'notifiable_type' => get_class($user),
            'notifiable_id' => $user->id,
            'user_id' => auth()->id(), // Get the currently logged-in user
            'data' => json_encode($notificationData),
            'device_type' => $detect->isMobile() ? 'Mobile' : ($detect->isTablet() ? 'Tablet' : 'Desktop'),
            'os' => $this->getOS($userAgent),
            'browser' => $this->getBrowser($userAgent),
            'brand' => $this->getDeviceBrand($userAgent),
            'user_agent' => $userAgent,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Manually insert the notification into the table
        DB::table('notifications')->insert($notificationDetails);

            // Send email with the generated password
            $user->notify(new UserCreatedNotification($user, $randomPassword));

            return redirect()->back()->with('success', 'User has been created successfully, and password has been sent to their email.');
        } catch (\Exception $e) {
            // Handle the error and return a message
            return redirect()->back()->with('error', 'An error occurred while creating the user: ' . $e->getMessage());
        }
    }




    // Update user information
    /*public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            // Define validation rules
            $validatedData = $request->validate([
                'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'name' => 'nullable|string|max:255',
                'email' => 'nullable|email|max:255|unique:users,email,' . $user->id,
                'gender' => 'nullable|string|max:10',
                'country' => 'nullable|string|max:100',
                'phone_no' => 'nullable|string|max:15',
                'phone_no2' => 'nullable|string|max:15',
                'role' => 'nullable|string|max:50',
                'IsActive' => 'nullable|boolean',
            ]);

            // Save photo file if provided
            if ($request->hasFile('photo')) {
                // Delete the old photo if exists
                if ($user->photo) {
                    Storage::delete($user->photo);
                }

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

            return redirect()->back()->with('success', 'User information has been updated successfully.');
        } catch (\Exception $e) {
            // Handle the error and return a message
            return redirect()->back()->with('error', 'An error occurred while updating the user: ' . $e->getMessage());
        }
    }*/

    public function update(Request $request, $id)
{
    try {
        $user = User::findOrFail($id);

        // Store original data (before update)
        $originalData = $user->toArray();

        // Define validation rules
        $validatedData = $request->validate([
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255|unique:users,email,' . $user->id,
            'gender' => 'nullable|string|max:10',
            'country' => 'nullable|string|max:100',
            'phone_no' => 'nullable|string|max:15',
            'phone_no2' => 'nullable|string|max:15',
            'role' => 'nullable|string|max:50',
            'IsActive' => 'nullable|boolean',
        ]);

        // Save photo file if provided
        if ($request->hasFile('photo')) {
            // Delete the old photo if exists
            if ($user->photo) {
                Storage::delete($user->photo);
            }

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

        // Prepare the notification data
        $notificationUpdateData = [
            'title' => 'User Updated',
            'message' => 'User information has been updated.',
            'details' => [
                'user_id' => $user->id,
                'changes' => $this->getChangedFields($originalData, $user->toArray()),
            ],
        ];

         // Get device and browser details
         $detect = new \Detection\MobileDetect;
         $userAgent = request()->header('User-Agent');
 
         $notificationDetails = [
             'id' => Str::uuid(),
             'type' => UserActivities::class,
             'notifiable_type' => get_class($user),
             'user_id' => auth()->id(), // Get the currently logged-in user
             'notifiable_id' => $user->id,
             'data' => json_encode($notificationUpdateData),
             'device_type' => $detect->isMobile() ? 'Mobile' : ($detect->isTablet() ? 'Tablet' : 'Desktop'),
             'os' => $this->getOS($userAgent),
             'browser' => $this->getBrowser($userAgent),
             'brand' => $this->getDeviceBrand($userAgent),
             'user_agent' => $userAgent,
             'created_at' => now(),
             'updated_at' => now(),
         ];
 
         // Manually insert the notification into the table
         DB::table('notifications')->insert($notificationDetails);
 

        return redirect()->back()->with('success', 'User information has been updated successfully.');
    } catch (\Exception $e) {
        // Handle the error and return a message
        return redirect()->back()->with('error', 'An error occurred while updating the user: ' . $e->getMessage());
    }
}



    // Soft delete a user
    public function softDelete($id)
    {
        $user = User::findOrFail($id);
        $user->delete(); // Soft delete
  // Prepare notification data with the user name and email
            $notificationSoftDeleteData = [
                'title' => 'User Softly Deleted',
                'message' => 'A user account has been removed to trash: ' . $user->name . ' and email: ' . $user->email,
                'details' => [
                    'user_id' => $user->id,
                    'email' => $user->email,
                ],
            ];

            // Get device and browser details
        $detect = new \Detection\MobileDetect;
        $userAgent = request()->header('User-Agent');

        $notificationDetails = [
            'id' => Str::uuid(),
            'type' => UserActivities::class,
            'notifiable_type' => get_class($user),
            'notifiable_id' => $user->id,
            'user_id' => auth()->id(), // Get the currently logged-in user
            'data' => json_encode($notificationSoftDeleteData),
            'device_type' => $detect->isMobile() ? 'Mobile' : ($detect->isTablet() ? 'Tablet' : 'Desktop'),
            'os' => $this->getOS($userAgent),
            'browser' => $this->getBrowser($userAgent),
            'brand' => $this->getDeviceBrand($userAgent),
            'user_agent' => $userAgent,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Manually insert the notification into the table
        DB::table('notifications')->insert($notificationDetails);
        
        return redirect()->back()->with('success', 'User soft deleted successfully.');
    }

    // Hard delete a user
    public function hardDelete($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->forceDelete(); // Hard delete

         // Prepare notification data with the user name and email
         $notificationHardDeleteData = [
            'title' => 'User Permanently Deleted',
            'message' => 'A user account has been permanently deleted: ' . $user->name . ' and email: ' . $user->email,
            'details' => [
                'user_id' => $user->id,
                'email' => $user->email,
            ],
        ];

        // Get device and browser details
    $detect = new \Detection\MobileDetect;
    $userAgent = request()->header('User-Agent');

    $notificationDetails = [
        'id' => Str::uuid(),
        'type' => UserActivities::class,
        'notifiable_type' => get_class($user),
        'notifiable_id' => $user->id,
        'user_id' => auth()->id(), // Get the currently logged-in user
        'data' => json_encode($notificationHardDeleteData),
        'device_type' => $detect->isMobile() ? 'Mobile' : ($detect->isTablet() ? 'Tablet' : 'Desktop'),
        'os' => $this->getOS($userAgent),
        'browser' => $this->getBrowser($userAgent),
        'brand' => $this->getDeviceBrand($userAgent),
        'user_agent' => $userAgent,
        'created_at' => now(),
        'updated_at' => now(),
    ];

    // Manually insert the notification into the table
    DB::table('notifications')->insert($notificationDetails);

        return redirect()->back()->with('success', 'User permanently deleted successfully.');
    }

    // Show soft-deleted users
    public function showTrashed()
    {
        $trashedUsers = User::onlyTrashed()->get();
        return view('admin.users.disabled.index', compact('trashedUsers'));
    }

    // Restore a soft-deleted user
    public function restore($id)
    {
        try {
            $user = User::withTrashed()->findOrFail($id);
            $user->restore(); // Restore the soft-deleted user

             // Prepare notification data with the user name and email
             $notificationRestoreData = [
                'title' => 'User Account restored',
                'message' => 'A user account has been restored successfully: ' . $user->name . ' and email: ' . $user->email,
                'details' => [
                    'user_id' => $user->id,
                    'email' => $user->email,
                ],
            ];

            // Get device and browser details
        $detect = new \Detection\MobileDetect;
        $userAgent = request()->header('User-Agent');

        $notificationDetails = [
            'id' => Str::uuid(),
            'type' => UserActivities::class,
            'notifiable_type' => get_class($user),
            'notifiable_id' => $user->id,
            'user_id' => auth()->id(), // Get the currently logged-in user
            'data' => json_encode($notificationRestoreData),
            'device_type' => $detect->isMobile() ? 'Mobile' : ($detect->isTablet() ? 'Tablet' : 'Desktop'),
            'os' => $this->getOS($userAgent),
            'browser' => $this->getBrowser($userAgent),
            'brand' => $this->getDeviceBrand($userAgent),
            'user_agent' => $userAgent,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Manually insert the notification into the table
        DB::table('notifications')->insert($notificationDetails);

            return redirect()->back()->with('success', 'User restored successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while restoring the user: ' . $e->getMessage());
        }
    }

    private function getChangedFields($originalData, $updatedData)
{
    $changes = [];

    foreach ($updatedData as $key => $newValue) {
        $originalValue = $originalData[$key] ?? null;
        if ($newValue !== $originalValue) {
            $changes[] = [
                'field' => $key,
                'before' => $originalValue,
                'after' => $newValue,
            ];
        }
    }

    return $changes;
}

public function testDeviceInfo()
{
    $detect = new MobileDetect();
    $userAgent = request()->header('User-Agent');

    // Detect device type
    if ($detect->isMobile()) {
        $device = 'Mobile device detected!';
    } elseif ($detect->isTablet()) {
        $device = 'Tablet detected!';
    } else {
        $device = 'Desktop device detected!';
    }

    // Detect browser and brand using custom methods
    $browser = $this->getBrowser($userAgent); // Custom method to detect browser
    $brand = $this->getDeviceBrand($userAgent); // Custom method to detect brand

    // Detect operating system
    $os = $this->getOS($userAgent); // Custom method to detect OS

    // Output the results for testing
    dd([
        'Device' => $device,
        'OS' => $os,
        'Browser' => $browser,
        'Brand' => $brand
    ]);
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
