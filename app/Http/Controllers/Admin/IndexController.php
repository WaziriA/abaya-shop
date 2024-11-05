<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomeCarousel;

class IndexController extends Controller
{
    //
    public function index(){
        $carouselItems=HomeCarousel::all();
        return view('admin/cms/index', compact('carouselItems'));
    }
     // Store a new carousel item
     public function store(Request $request)
     {
         $validatedData = $request->validate([
             'up' => 'nullable|string|max:255',
             'middle' => 'nullable|string|max:255',
             'description' => 'nullable|string',
             'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
         ]);
 
         if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = time() . '.' . $photo->getClientOriginalExtension(); // Generate unique file name
            $photoPath = $photo->storeAs('public/carousel_photos', $photoName); // Store image in specified directory
    
            // Save the path in the validated data array
            $validatedData['photo'] = 'carousel_photos/' . $photoName;
        }
        //dd($photoPath);
        // dd($validatedData);
         HomeCarousel::create($validatedData);
         
         return redirect()->back()->with('success', 'Carousel item added successfully.');
     }
 
     // Show the form for editing a specific item
     public function edit($id)
     {
         $carousel = HomeCarousel::findOrFail($id);
         return view('carousel.edit', compact('carousel'));
     }
 
     public function update(Request $request, $id)
     {
         try {
             // Find the carousel item
             $carousel = HomeCarousel::findOrFail($id);
     
             // Define validation rules
             $validatedData = $request->validate([
                 'up' => 'nullable|string|max:255',
                 'middle' => 'nullable|string|max:255',
                 'description' => 'nullable|string',
                 'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
             ]);
     
             // Handle file upload for photo
             if ($request->hasFile('photo')) {
                 // Delete old photo if exists
                 if ($carousel->photo) {
                     Storage::delete('public/carousel_photos/' . $carousel->photo);
                 }
                 $filePath = $request->file('photo')->store('public/carousel_photos');
                 $validatedData['photo'] = basename($filePath); // Store only the filename
             }
     
             // Update only the fields that were provided in the request
             foreach ($validatedData as $key => $value) {
                 if ($value !== null) {
                     $carousel->$key = $value;
                 }
             }
     
             // Save the updated carousel item
             $carousel->save();
     
             return redirect()->back()->with('success', 'Carousel item updated successfully.');
         } catch (\Exception $e) {
             // Handle the error and return a message
             return redirect()->back()->with('error', 'An error occurred while updating the carousel item: ' . $e->getMessage());
         }
     }

     
     // Delete a carousel item
     public function destroy($id)
     {
         $carousel = HomeCarousel::findOrFail($id);
         
         // Delete photo from storage
         if ($carousel->photo) {
             Storage::delete('public/carousel_photos/' . $carousel->photo);
         }
 
         $carousel->delete();
         
         return redirect()->back()->with('success', 'Carousel item deleted successfully.');
     }

       // Soft delete a carousel item
    public function softDelete($id)
    {
        $carousel = HomeCarousel::findOrFail($id);
        $carousel->delete();

        return redirect()->back()->with('success', 'Carousel item soft deleted successfully.');
    }

    // Hard delete a carousel item
    public function hardDelete($id)
    {
        $carousel = HomeCarousel::withTrashed()->findOrFail($id);
        $carousel->forceDelete();

        return redirect()->back()->with('success', 'Carousel item hard deleted successfully.');
    }

    // Retrieve trashed items
    public function trashedItems()
    {
        $trashedItems = HomeCarousel::onlyTrashed()->get();

        return view('admin/cms/deleted-items', compact('trashedItems'));
    }

     // Restore a soft-deleted carousel item
     public function restore($id)
     {
         try {
             $carousel = HomeCarousel::withTrashed()->findOrFail($id);
             $carousel->restore();
 
             return redirect()->back()->with('success', 'Carousel item restored successfully.');
         } catch (\Exception $e) {
             return redirect()->back()->with('error', 'An error occurred while restoring the carousel item: ' . $e->getMessage());
         }
     }

 }
