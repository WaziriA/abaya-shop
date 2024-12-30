<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\User;
use App\Notifications\NewContactMessageNotification;

class ContactController extends Controller
{
    //
    public function index(){
        $contacts = Contact::all();
        return view('store/contact', compact('contacts'));
    }

     // Store a new contact
     // Store a new contact
public function store(Request $request)
{
    // Validate the request data
    $validatedData = $request->validate([
        'email' => 'required|email|max:255',
        'subject' => 'required|string|max:255',
        'company' => 'nullable|string|max:255',
        'message' => 'required|string',
        'name' => 'required|string|max:255',
    ]);

    // Create and save the new contact, and store it in $contact
    $contact = Contact::create($validatedData);

    // Find all users with the "owner" role
    $owners = User::where('role', 'owner')->get();

    // Send notification to each owner
    foreach ($owners as $owner) {
        $owner->notify(new NewContactMessageNotification($contact));
    }

    // Redirect back with a success message
    return redirect()->back()->with('success', 'Contact message sent successfully.');
}

 
     // Delete a contact
     public function destroy($id)
     {
         // Find the contact by ID and delete it
         $contact = Contact::findOrFail($id);
         $contact->delete();
 
         // Redirect back with a success message
         return redirect()->back()->with('success', 'Contact message deleted successfully.');
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
