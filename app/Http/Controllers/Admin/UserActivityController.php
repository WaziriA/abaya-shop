<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserActivityController extends Controller
{
    //
    public function index()
    {
        // Fetch notifications with user details
        $notifications = DB::table('notifications')
            ->join('users', 'notifications.user_id', '=', 'users.id')
            ->select(
                'notifications.user_id', // Add this line to select the user_id
                'users.name as user_name',
                'users.role as user_role',
                'notifications.data',
                'notifications.device_type',
                'notifications.browser',
                'notifications.brand',
                'notifications.os',
                'notifications.created_at'
            )
            ->orderBy('notifications.created_at', 'desc')
            ->get();

            $createdAt = \Carbon\Carbon::now();

        return view('admin.user-activity.index', compact('notifications','createdAt'));
    }

    public function showDetails($id, $month)
{
    // Parse the month to a Carbon instance (to help with filtering activities by date)
    $startOfMonth = Carbon::parse($month)->startOfMonth();
    $endOfMonth = Carbon::parse($month)->endOfMonth();

    // Fetch notifications for the user within the given month
    $activities = DB::table('notifications')
        ->join('users', 'notifications.user_id', '=', 'users.id')
        ->select(
            'users.name as user_name',
            'users.role as user_role',
            'notifications.data',
            'notifications.device_type',
            'notifications.browser',
            'notifications.brand',
            'notifications.os',
            'notifications.created_at'
        )
        ->where('notifications.user_id', $id)
        ->whereBetween('notifications.created_at', [$startOfMonth, $endOfMonth])
        ->orderBy('notifications.created_at', 'desc')
        ->get();

    // Fetch the user details
    $user = DB::table('users')->find($id);

    return view('admin.user-activity.details', compact('activities', 'user', 'month'));
}


    
}
