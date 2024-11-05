<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OfflineOrder;

class OfflineOrderController extends Controller
{
    //
    public function index(){
        return view('admin/offline-order/index');
    }
    public function completeOrders(){
        return view('admin/offline-order/complete');
    }
    public function transitOrders(){
        return view('admin/offline-order/in-transit');
    }
    public function pendingOrders(){
        return view('admin/offline-order/pending');
    }
}
