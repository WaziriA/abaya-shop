<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class OwnerController extends Controller
{
    //
    public function index()
    {
        $owners = User::where('role', 'owner')->get();
        return view('admin.users.owner.index', compact('owners'));
    }

    public function showStaffs(){
        $staffs = User::where('role', 'staff')->get();
        return view('admin.users.staffs.index', compact('staffs'));
    }
}
