<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    //
    public function index(){
        $user = Auth::user(); // Get the currently authenticated user

        return view('admin/profile/view-profile/index', compact('user'));
    }
}
