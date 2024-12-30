<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    //
    public function index(){
        $categories = Category::withCount('products')->get();
        return view('admin/category/index', compact('categories'));
    }
    public function store(Request $request)
{
    try {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255'
        ]);

        Category::create($validatedData);

        return redirect()->route('category.index')->with('success', 'Category added successfully');
    } catch (\Exception $e) {
        return redirect()->route('category.index')->with('error', 'Failed to add category: ' . $e->getMessage());
    }
}
public function update(Request $request, $id)
{
    try {
        $category = Category::findOrFail($id);

        // Define validation rules
        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string|max:255'
        ]);

        // Update only the fields that were provided in the request
        foreach ($validatedData as $key => $value) {
            // Check if the value is not null and update the corresponding field
            if ($value !== null) {
                $category->$key = $value;
            }
        }

        // Save the updated category
        $category->save();

        return redirect()->route('category.index')->with('success', 'Category updated successfully');
    } catch (\Exception $e) {
        return redirect()->route('category.index')->with('error', 'Failed to update category: ' . $e->getMessage());
    }
}

public function softDelete($id)
{
    try {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('category.index')->with('success', 'Category moved to trash successfully');
    } catch (\Exception $e) {
        return redirect()->route('category.index')->with('error', 'Failed to move category to trash: ' . $e->getMessage());
    }
}

public function forceDelete($id)
{
    try {
        $category = Category::withTrashed()->findOrFail($id);
        $category->forceDelete();

        return redirect()->route('category.index')->with('success', 'Category permanently deleted successfully');
    } catch (\Exception $e) {
        return redirect()->route('category.index')->with('error', 'Failed to permanently delete category: ' . $e->getMessage());
    }
}

public function deletedCategories()
{
    try {
        $deletedCategories = Category::onlyTrashed()->get();
        return view('admin/category/deleted-categories', compact('deletedCategories'));
    } catch (\Exception $e) {
        return redirect()->route('category.index')->with('error', 'Failed to retrieve deleted categories: ' . $e->getMessage());
    }
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
