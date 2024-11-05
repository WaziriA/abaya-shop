<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    //
    public function showLoginForm()
    {
        return view('auth.login'); // Optional if using a separate view
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        if (Auth::attempt($request->only('email', 'password'))) {
            // Retrieve the authenticated user's role
            $userRole = Auth::user()->role;
    
            // Redirect based on the role
            if (in_array($userRole, ['owner', 'staff'])) {
                return redirect()->route('dashboard.index')->with('success', 'you login successfully'); // Redirect to dashboard for owner and staff
            } else {
                return redirect()->route('home.index')->with('success', 'you login successfully');; // Redirect to home for customers
            }
        }
    
        // If authentication fails, return with an error
        return back()->with('error', 'User with this credentials not found');
            
        
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }
}
