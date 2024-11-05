<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str; // Import Str facade
use Illuminate\Support\Facades\Log;
use App\Models\user;
use App\Notifications\UserCreatedNotification; // Import your notification class
use Exception;
use session;

class UserController extends Controller
{
    //
    public function index(){
        
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
    
            
            // Send email with the generated password
          $user->notify(new UserCreatedNotification($user, $randomPassword));
    
            return redirect()->back()->with('success', 'User has been created successfully, and password has been sent to their email.');
        } catch (\Exception $e) {
            // Handle the error and return a message
            return redirect()->back()->with('error', 'An error occurred while creating the user: ' . $e->getMessage());
        }
    }




     // Update user information
     public function update(Request $request, $id)
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
     }

     // Soft delete a user
    public function softDelete($id)
    {
        $user = User::findOrFail($id);
        $user->delete(); // Soft delete
        return redirect()->back()->with('success', 'User soft deleted successfully.');
    }

    // Hard delete a user
    public function hardDelete($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->forceDelete(); // Hard delete
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

        return redirect()->back()->with('success', 'User restored successfully.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'An error occurred while restoring the user: ' . $e->getMessage());
    }
}

}
