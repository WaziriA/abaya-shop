<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class RegistrationController extends Controller
{
    //
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required',
            'email' => 'required|email|unique:users',
            'country' => 'required|string',
            'phone_no' => 'required|string',
            'phone_no2' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->gender = $request->gender;
        $user->email = $request->email;
        $user->country = $request->country;
        $user->phone_no = $request->phone_no;
        $user->phone_no2 = $request->phone_no2;
        $user->role = 'customer'; // Set the default role to 'customer'
        
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('public/photos');
            $user->photo = basename($path);
        }
        
        $user->password = Hash::make($request->password);
        $user->save();

        Auth::login($user);

        return redirect()->route('home.index')->with('success', 'your account has been created successfully');
    }
}
