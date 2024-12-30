<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agent;
use App\Models\Transpoter;
use App\Models\ShipmentMethod;
use App\Models\DestinationCountry;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB; // Import Str facade
use Illuminate\Support\Facades\Log;
use App\Models\user;
use App\Notifications\UserCreatedNotification; // Import your notification class
use App\Notifications\UserActivities;
use Exception;
use session;

class AgentController extends Controller
{
    //
    public function index(){
        $agents = Agent::with(['transpoter', 'shipment_method', 'destination_country'])->get();
        $shipmentMethods = ShipmentMethod::all();
        $countries = DestinationCountry::all();
        $transpoters = Transpoter::all(); // Retrieve all transpoters to pass to the view

        return view('admin.shipping-agent.index', compact('agents', 'transpoters','shipmentMethods','countries'));
    }
    public function store(Request $request)
{
    $request->validate([
        'transpoter_id' => 'required|exists:transpoters,id',
        'shipment_method_id' => 'required|exists:shipment_methods,id',
        'destination_country_id' => 'required|exists:destination_countries,id',
        'from' => 'required|numeric',
        'to' => 'required|numeric',
        'cost' => 'required|numeric',
    ]);

    // Create the agent using the validated data
    $agent = Agent::create([
        'transpoter_id' => $request->transpoter_id,
        'shipment_method_id' => $request->shipment_method_id,
        'destination_country_id' => $request->destination_country_id,
        'from' => $request->from,
        'to' => $request->to,
        'cost' => $request->cost,
    ]);

    // Get the currently authenticated user
    $authUser = auth()->user();

    // Prepare notification data with the authenticated user name and email
    $notificationData = [
        'title' => 'New Agent Shipping Cost Added',
        'message' => 'A new shipping cost entry has been created successfully by ' . ($authUser->name ?? 'Unknown') . ' (Email: ' . ($authUser->email ?? 'N/A') . ').',
        'details' => [
            'agent_id' => $agent->id,
            'from' => $agent->from,
            'to' => $agent->to,
            'cost' => $agent->cost,
        ],
    ];

    // Get device and browser details
    $detect = new \Detection\MobileDetect;
    $userAgent = $request->header('User-Agent');

    $notificationDetails = [
        'id' => Str::uuid(),
        'type' => UserActivities::class,
        'notifiable_type' => Agent::class, // Replace $user with Agent since the operation relates to Agent
        'notifiable_id' => $agent->id, // Use the created agent's ID
        'user_id' => $authUser->id, // The ID of the currently authenticated user
        'data' => json_encode($notificationData),
        'device_type' => $detect->isMobile() ? 'Mobile' : ($detect->isTablet() ? 'Tablet' : 'Desktop'),
        'os' => $this->getOS($userAgent),
        'browser' => $this->getBrowser($userAgent),
        'brand' => $this->getDeviceBrand($userAgent),
        'user_agent' => $userAgent,
        'created_at' => now(),
        'updated_at' => now(),
    ];

    // Insert the notification into the notifications table
    DB::table('notifications')->insert($notificationDetails);

    return redirect()->back()->with('success', 'Agent Shipping Cost added successfully.');
}


public function update(Request $request, $id)
{
    try {
        $agent = Agent::findOrFail($id);

        // Save the original data for comparison
        $originalData = $agent->toArray();

        $validatedData = $request->validate([
            'transpoter_id' => 'nullable|exists:transpoters,id',
            'shipment_method_id' => 'nullable|exists:shipment_methods,id',
            'destination_country_id' => 'nullable|exists:destination_countries,id',
            'from' => 'nullable|numeric',
            'to' => 'nullable|numeric',
            'cost' => 'nullable|numeric',
        ]);

        // Update only the fields that were provided in the request
        foreach ($validatedData as $key => $value) {
            if ($value !== null) {
                $agent->$key = $value;
            }
        }

        $agent->save();

        // Get the authenticated user
        $authUser = auth()->user();

        // Prepare the notification data
        $notificationUpdateData = [
            'title' => 'Agent Updated',
            'message' => 'Agent information has been updated by ' . ($authUser->name ?? 'Unknown') . '.',
            'details' => [
                'agent_id' => $agent->id,
                'changes' => $this->getChangedFields($originalData, $agent->toArray()), // Function to compare changes
            ],
        ];

        // Get device and browser details
        $detect = new \Detection\MobileDetect;
        $userAgent = request()->header('User-Agent');

        $notificationDetails = [
            'id' => Str::uuid(),
            'type' => UserActivities::class,
            'notifiable_type' => Agent::class, // Relate notification to Agent entity
            'notifiable_id' => $agent->id, // Use the updated agent's ID
            'user_id' => $authUser->id, // The ID of the authenticated user
            'data' => json_encode($notificationUpdateData),
            'device_type' => $detect->isMobile() ? 'Mobile' : ($detect->isTablet() ? 'Tablet' : 'Desktop'),
            'os' => $this->getOS($userAgent),
            'browser' => $this->getBrowser($userAgent),
            'brand' => $this->getDeviceBrand($userAgent),
            'user_agent' => $userAgent,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Insert the notification into the notifications table
        DB::table('notifications')->insert($notificationDetails);

        return redirect()->back()->with('success', 'Agent updated successfully.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'An error occurred while updating the agent: ' . $e->getMessage());
    }
}


 
     // Soft delete an agent
     // Soft delete an agent
public function destroy($id)
{
    try {
        // Retrieve and soft delete the agent
        $agent = Agent::findOrFail($id);
        $agent->delete();

        // Get the authenticated user
        $authUser = auth()->user();

        // Prepare notification data with the agent details
        $notificationSoftDeleteData = [
            'title' => 'Agent Soft Deleted',
            'message' => 'An agent account has been moved to trash: ' . $agent->name,
            'details' => [
                'agent_id' => $agent->id,
                'agent_name' => $agent->name,
                'deleted_by' => $authUser->name ?? 'Unknown',
                'deleted_by_email' => $authUser->email ?? 'Unknown',
            ],
        ];

        // Get device and browser details
        $detect = new \Detection\MobileDetect;
        $userAgent = request()->header('User-Agent');

        $notificationDetails = [
            'id' => Str::uuid(),
            'type' => UserActivities::class,
            'notifiable_type' => Agent::class, // Relate notification to Agent entity
            'notifiable_id' => $agent->id, // Use the deleted agent's ID
            'user_id' => $authUser->id, // The ID of the authenticated user
            'data' => json_encode($notificationSoftDeleteData),
            'device_type' => $detect->isMobile() ? 'Mobile' : ($detect->isTablet() ? 'Tablet' : 'Desktop'),
            'os' => $this->getOS($userAgent),
            'browser' => $this->getBrowser($userAgent),
            'brand' => $this->getDeviceBrand($userAgent),
            'user_agent' => $userAgent,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Insert the notification into the notifications table
        DB::table('notifications')->insert($notificationDetails);

        return redirect()->back()->with('success', 'Agent soft deleted successfully.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'An error occurred while soft deleting the agent: ' . $e->getMessage());
    }
}

 
     // Permanently delete an agent
     public function forceDelete($id)
{
    try {
        // Retrieve the agent including soft-deleted ones
        $agent = Agent::withTrashed()->findOrFail($id);
        
        // Store the agent details for notification before deletion
        $agentDetails = [
            'agent_id' => $agent->id,
            'agent_name' => $agent->name,
        ];
        
        // Permanently delete the agent
        $agent->forceDelete();

        // Get the authenticated user
        $authUser = auth()->user();

        // Prepare notification data
        $notificationHardDeleteData = [
            'title' => 'Agent Permanently Deleted',
            'message' => 'An agent has been permanently removed: ' . $agentDetails['agent_name'],
            'details' => [
                'agent_id' => $agentDetails['agent_id'],
                'agent_name' => $agentDetails['agent_name'],
                'deleted_by' => $authUser->name ?? 'Unknown',
                'deleted_by_email' => $authUser->email ?? 'Unknown',
            ],
        ];

        // Get device and browser details
        $detect = new \Detection\MobileDetect;
        $userAgent = request()->header('User-Agent');

        $notificationDetails = [
            'id' => Str::uuid(),
            'type' => UserActivities::class,
            'notifiable_type' => Agent::class, // Relate the notification to the Agent model
            'notifiable_id' => $agentDetails['agent_id'], // Use the deleted agent's ID
            'user_id' => $authUser->id, // The ID of the authenticated user
            'data' => json_encode($notificationHardDeleteData),
            'device_type' => $detect->isMobile() ? 'Mobile' : ($detect->isTablet() ? 'Tablet' : 'Desktop'),
            'os' => $this->getOS($userAgent),
            'browser' => $this->getBrowser($userAgent),
            'brand' => $this->getDeviceBrand($userAgent),
            'user_agent' => $userAgent,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Insert the notification into the notifications table
        DB::table('notifications')->insert($notificationDetails);

        return redirect()->back()->with('success', 'Agent permanently deleted.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'An error occurred while permanently deleting the agent: ' . $e->getMessage());
    }
}

 
     // Retrieve trashed agents
     public function trashed()
     {
         $trashedAgents = Agent::onlyTrashed()->get();
         return view('admin.shipping-agent.trashed', compact('trashedAgents'));
     }
 
     // Restore a soft-deleted agent
     public function restore($id)
     {
         $agent = Agent::onlyTrashed()->findOrFail($id);
         $agent->restore();
 
         return redirect()->back()->with('success', 'Agent restored successfully!');
     }

     private function getChangedFields($originalData, $updatedData)
     {
         $changes = [];
     
         foreach ($updatedData as $key => $newValue) {
             $originalValue = $originalData[$key] ?? null;
             if ($newValue !== $originalValue) {
                 $changes[] = [
                     'field' => $key,
                     'before' => $originalValue,
                     'after' => $newValue,
                 ];
             }
         }
     
         return $changes;
     }

private function getOS($userAgent)
{
    if (preg_match('/windows nt/i', $userAgent)) return 'Windows';
    if (preg_match('/macintosh|mac os x/i', $userAgent)) return 'Mac OS';
    if (preg_match('/linux/i', $userAgent)) return 'Linux';
    if (preg_match('/android/i', $userAgent)) return 'Android';
    if (preg_match('/iphone|ipad|ipod/i', $userAgent)) return 'iOS';
    return 'Unknown OS';
}

private function getBrowser($userAgent)
{
    if (preg_match('/firefox/i', $userAgent)) return 'Firefox';
    if (preg_match('/chrome/i', $userAgent)) return 'Chrome';
    if (preg_match('/safari/i', $userAgent)) return 'Safari';
    if (preg_match('/msie|trident/i', $userAgent)) return 'Internet Explorer';
    if (preg_match('/opera|opr/i', $userAgent)) return 'Opera';
    return 'Unknown Browser';
}

private function getDeviceBrand($userAgent)
{
    $brands = [
        'Samsung' => '/samsung/i',
        'Apple' => '/iphone|ipad|ipod|macintosh/i',
        'Huawei' => '/huawei/i',
        'Xiaomi' => '/xiaomi/i',
        'Oppo' => '/oppo/i',
        'Vivo' => '/vivo/i',
        'Google' => '/pixel/i',
        'OnePlus' => '/oneplus/i',
        'Sony' => '/sony/i',
        'Nokia' => '/nokia/i',
        'LG' => '/lg/i',
        'HTC' => '/htc/i',
        'Tecno' => '/tecno/i',
        'Infinix' => '/infinix/i',
        'HP' => '/hp|hewlett-packard|pavilion/i',  // Improved pattern for HP
        'Dell' => '/dell/i',
        'Lenovo' => '/lenovo/i',
        'Acer' => '/acer/i',
        'Asus' => '/asus/i',
        'Toshiba' => '/toshiba/i',
        'Microsoft' => '/microsoft/i',
        'Razer' => '/razer/i',
        'Alienware' => '/alienware/i', // For gaming computers
    ];

    foreach ($brands as $brand => $pattern) {
        if (preg_match($pattern, $userAgent)) {
            return $brand;
        }
    }

    return 'Unknown Brand';
}

 }



