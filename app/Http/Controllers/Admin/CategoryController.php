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

    
}
