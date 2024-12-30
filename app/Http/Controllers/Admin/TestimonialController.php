<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeTestimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    //
    public function index()
    {
        $testimonials = HomeTestimonial::all();  // Get all testimonials
        return view('admin.testimonial.index', compact('testimonials'));
    }

    // Store a new testimonial
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'specialization' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
        ]);

        // Handle image upload if present
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('testimonials', 'public');
        } else {
            $imagePath = null;
        }

        // Create a new testimonial
        HomeTestimonial::create([
            'name' => $request->name,
            'description' => $request->description,
            'specialization' => $request->specialization,
            'company' => $request->company,
            'image' => $imagePath,
        ]);

        return redirect()->back()->with('success', 'Testimonial added successfully');
    }

    // Update an existing testimonial
    public function update(Request $request, $id)
{
    try {
        // Find the testimonial by ID
        $testimonial = HomeTestimonial::findOrFail($id);

        // Define validation rules
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'specialization' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload if a new image is provided
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($testimonial->image) {
                Storage::delete('public/' . $testimonial->image);
            }

            // Store the new image
            $imagePath = $request->file('image')->store('testimonials', 'public');
            $validatedData['image'] = $imagePath; // Store the new image path
        }

        // Update only the fields that are provided in the request
        foreach ($validatedData as $key => $value) {
            if ($value !== null) {
                $testimonial->$key = $value;
            }
        }

        // Save the updated testimonial
        $testimonial->save();

        return redirect()->back()->with('success', 'Testimonial updated successfully');
    } catch (\Exception $e) {
        // Handle the error and return a message
        return redirect()->back()->with('error', 'An error occurred while updating the testimonial: ' . $e->getMessage());
    }
}


    // Delete a testimonial
    public function destroy($id)
    {
        $testimonial = HomeTestimonial::findOrFail($id);

        // Delete the image if it exists
        if ($testimonial->image) {
            Storage::delete('public/' . $testimonial->image);
        }

        // Delete the testimonial from the database
        $testimonial->delete();

        return redirect()->back()->with('success', 'Testimonial deleted successfully');
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
