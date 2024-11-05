<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscriber;

class SubscriberController extends Controller
{
    //
    public function index(){
        $subscribers = Subscriber::all();
        return view('admin/users/subscriber/index', compact('subscribers'));
    }
    // Store a new subscriber
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:subscribers,email'
        ]);

        Subscriber::create([
            'name' => $request->name,
            'email' => $request->email
        ]);

        return redirect()->back()->with('success', 'Subscriber added successfully.');
    }
}
