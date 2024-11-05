<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class CustomerController extends Controller
{
    //
    //
    public function index() {
        $customers = User::where('role', 'customer')->get(); // Retrieve users with role 'customer'
        
        return view('admin.users.customer.index', compact('customers'));
    }
    
}
