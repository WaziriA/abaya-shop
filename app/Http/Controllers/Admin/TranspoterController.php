<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transpoter;
use App\Models\ShipmentMethod;
use App\Models\DestinationCountry;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB; // Import Str facade
use Illuminate\Support\Facades\Log;
use App\Models\user;
use App\Notifications\UserCreatedNotification; // Import your notification class
use App\Notifications\UserActivities;
use Exception;
use session;

class TranspoterController extends Controller
{
    //
    public function index()
    {
        $transpoters = Transpoter::all();
        $shipments = ShipmentMethod::all();
        $countries = DestinationCountry::all();
        return view('admin.transpoter.index', compact('transpoters','countries','shipments'));
    }

    // Store a new transpoter
    public function store(Request $request)
{
    try {
        // Validate the request
        $request->validate([
            'transpoter_name' => 'required|string|max:255',
        ]);

        // Create the transporter
        $transpoter = Transpoter::create([
            'transpoter_name' => $request->transpoter_name,
        ]);

        // Prepare notification data for the new transporter
        $notificationData = [
            'title' => 'New Transporter Created',
            'message' => 'A new transporter has been created successfully with the name: ' . $transpoter->transpoter_name,
            'details' => [
                'transpoter_id' => $transpoter->id,
                'transpoter_name' => $transpoter->transpoter_name,
                'created_by' => auth()->user()->name ?? 'Unknown', // Authenticated user's name
            ],
        ];

        // Get device and browser details
        $detect = new \Detection\MobileDetect;
        $userAgent = request()->header('User-Agent');

        $notificationDetails = [
            'id' => Str::uuid(),
            'type' => 'App\\Notifications\\TransporterActivity', // Notification type
            'notifiable_type' => Transpoter::class, // Associated with the Transpoter model
            'notifiable_id' => $transpoter->id, // Transpoter ID
            'user_id' => auth()->id(), // Authenticated user ID
            'data' => json_encode($notificationData),
            'device_type' => $detect->isMobile() ? 'Mobile' : ($detect->isTablet() ? 'Tablet' : 'Desktop'),
            'os' => $this->getOS($userAgent),
            'browser' => $this->getBrowser($userAgent),
            'brand' => $this->getDeviceBrand($userAgent),
            'user_agent' => $userAgent,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Insert the notification into the table
        DB::table('notifications')->insert($notificationDetails);

        return redirect()->back()->with('success', 'Transpoter added successfully.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'An error occurred while adding the transporter: ' . $e->getMessage());
    }
}


    // Update an existing transpoter
    public function update(Request $request, $id)
{
    try {
        // Validate the request
        $request->validate([
            'transpoter_name' => 'required|string|max:255',
        ]);

        // Find the transporter
        $transpoter = Transpoter::findOrFail($id);

        // Capture original data before the update
        $originalData = $transpoter->toArray();

        // Update the transporter
        $transpoter->update([
            'transpoter_name' => $request->transpoter_name,
        ]);

        // Prepare the notification data
        $notificationUpdateData = [
            'title' => 'Transporter Updated',
            'message' => 'The transporter information has been updated successfully.',
            'details' => [
                'transpoter_id' => $transpoter->id,
                'changes' => $this->getChangedFields($originalData, $transpoter->toArray()),
            ],
        ];

        // Get device and browser details
        $detect = new \Detection\MobileDetect;
        $userAgent = request()->header('User-Agent');

        $notificationDetails = [
            'id' => Str::uuid(),
            'type' => 'App\\Notifications\\TransporterActivity', // Notification type
            'notifiable_type' => Transpoter::class, // Associated with the Transpoter model
            'notifiable_id' => $transpoter->id, // Transpoter ID
            'user_id' => auth()->id(), // Authenticated user ID
            'data' => json_encode($notificationUpdateData),
            'device_type' => $detect->isMobile() ? 'Mobile' : ($detect->isTablet() ? 'Tablet' : 'Desktop'),
            'os' => $this->getOS($userAgent),
            'browser' => $this->getBrowser($userAgent),
            'brand' => $this->getDeviceBrand($userAgent),
            'user_agent' => $userAgent,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Insert the notification into the table
        DB::table('notifications')->insert($notificationDetails);

        return redirect()->back()->with('success', 'Transporter updated successfully.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'An error occurred while updating the transporter: ' . $e->getMessage());
    }
}


    // Soft delete a transpoter
    public function destroy($id)
{
    try {
        // Find the transporter by ID
        $transpoter = Transpoter::findOrFail($id);

        // Soft delete the transporter
        $transpoter->delete();

        // Prepare notification data for the soft delete
        $notificationSoftDeleteData = [
            'title' => 'Transporter Soft Deleted',
            'message' => 'A transporter has been moved to trash.',
            'details' => [
                'transpoter_id' => $transpoter->id,
                'transpoter_name' => $transpoter->transpoter_name,
            ],
        ];

        // Get device and browser details
        $detect = new \Detection\MobileDetect;
        $userAgent = request()->header('User-Agent');

        $notificationDetails = [
            'id' => Str::uuid(),
            'type' => 'App\\Notifications\\TransporterActivity', // Notification type
            'notifiable_type' => Transpoter::class, // Associated with the Transpoter model
            'notifiable_id' => $transpoter->id, // Transporter ID
            'user_id' => auth()->id(), // Authenticated user ID
            'data' => json_encode($notificationSoftDeleteData),
            'device_type' => $detect->isMobile() ? 'Mobile' : ($detect->isTablet() ? 'Tablet' : 'Desktop'),
            'os' => $this->getOS($userAgent),
            'browser' => $this->getBrowser($userAgent),
            'brand' => $this->getDeviceBrand($userAgent),
            'user_agent' => $userAgent,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Insert the notification into the table
        DB::table('notifications')->insert($notificationDetails);

        return redirect()->back()->with('success', 'Transporter soft deleted successfully.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'An error occurred while deleting the transporter: ' . $e->getMessage());
    }
}


    // Permanently delete a transpoter
    public function forceDelete($id)
{
    try {
        // Find the transporter (even soft-deleted ones)
        $transpoter = Transpoter::withTrashed()->findOrFail($id);

        // Store transporter details before deletion for notification
        $transpoterDetails = [
            'transpoter_id' => $transpoter->id,
            'transpoter_name' => $transpoter->transpoter_name,
        ];

        // Permanently delete the transporter
        $transpoter->forceDelete();

        // Prepare notification data
        $notificationHardDeleteData = [
            'title' => 'Transporter Permanently Deleted',
            'message' => 'A transporter has been permanently deleted.',
            'details' => $transpoterDetails,
        ];

        // Get device and browser details
        $detect = new \Detection\MobileDetect;
        $userAgent = request()->header('User-Agent');

        $notificationDetails = [
            'id' => Str::uuid(),
            'type' => 'App\\Notifications\\TransporterActivity', // Notification type
            'notifiable_type' => Transpoter::class, // Associated with the Transpoter model
            'notifiable_id' => $transpoterDetails['transpoter_id'], // Transporter ID
            'user_id' => auth()->id(), // Authenticated user ID
            'data' => json_encode($notificationHardDeleteData),
            'device_type' => $detect->isMobile() ? 'Mobile' : ($detect->isTablet() ? 'Tablet' : 'Desktop'),
            'os' => $this->getOS($userAgent),
            'browser' => $this->getBrowser($userAgent),
            'brand' => $this->getDeviceBrand($userAgent),
            'user_agent' => $userAgent,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Insert the notification into the table
        DB::table('notifications')->insert($notificationDetails);

        return redirect()->back()->with('success', 'Transporter permanently deleted.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'An error occurred while permanently deleting the transporter: ' . $e->getMessage());
    }
}

    // Method to retrieve trashed transporters
public function trashed()
{
    $trashedTransporters = Transpoter::onlyTrashed()->get();
    return view('admin/transpoter/trashed', compact('trashedTransporters'));
}

// Method to restore a transporter
public function restore($id)
{
    try {
        // Find the trashed transporter
        $transporter = Transpoter::onlyTrashed()->findOrFail($id);

        // Store transporter details before restoration for notification
        $transporterDetails = [
            'transpoter_id' => $transporter->id,
            'transpoter_name' => $transporter->transpoter_name,
        ];

        // Restore the trashed transporter
        $transporter->restore();

        // Prepare notification data
        $notificationRestoreData = [
            'title' => 'Transporter Restored',
            'message' => 'A transporter has been successfully restored.',
            'details' => $transporterDetails,
        ];

        // Get device and browser details
        $detect = new \Detection\MobileDetect;
        $userAgent = request()->header('User-Agent');

        $notificationDetails = [
            'id' => Str::uuid(),
            'type' => 'App\\Notifications\\TransporterActivity', // Notification type
            'notifiable_type' => Transpoter::class, // Associated with the Transpoter model
            'notifiable_id' => $transporterDetails['transpoter_id'], // Transporter ID
            'user_id' => auth()->id(), // Authenticated user ID
            'data' => json_encode($notificationRestoreData),
            'device_type' => $detect->isMobile() ? 'Mobile' : ($detect->isTablet() ? 'Tablet' : 'Desktop'),
            'os' => $this->getOS($userAgent),
            'browser' => $this->getBrowser($userAgent),
            'brand' => $this->getDeviceBrand($userAgent),
            'user_agent' => $userAgent,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Insert the notification into the table
        DB::table('notifications')->insert($notificationDetails);

        return redirect()->back()->with('success', 'Transporter restored successfully!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'An error occurred while restoring the transporter: ' . $e->getMessage());
    }
}


      // Store a new shipment method
      public function storeShipmentMethod(Request $request)
      {
          // Validate the input
          $validator = Validator::make($request->all(), [
              'method_name' => 'required|unique:shipment_methods'
          ]);
      
          if ($validator->fails()) {
              return back()->withErrors($validator)->withInput();
          }
      
          // Create the new shipment method
          $method = ShipmentMethod::create([
              'method_name' => $request->method_name
          ]);
      
          // Prepare notification data for the creation of a new shipment method
          $notificationData = [
              'title' => 'New Shipment Method Created',
              'message' => 'A new shipment method has been added with the name: ' . $method->method_name,
              'details' => [
                  'method_name' => $method->method_name,
                  'method_id' => $method->id,
              ],
          ];
      
          // Get device and browser details
          $detect = new \Detection\MobileDetect;
          $userAgent = request()->header('User-Agent');
      
          $notificationDetails = [
              'id' => Str::uuid(),
              'type' => 'App\\Notifications\\ShipmentMethodActivity', // Notification type
              'notifiable_type' => ShipmentMethod::class, // Associated with ShipmentMethod model
              'notifiable_id' => $method->id, // Shipment method ID
              'user_id' => auth()->id(), // Authenticated user ID
              'data' => json_encode($notificationData),
              'device_type' => $detect->isMobile() ? 'Mobile' : ($detect->isTablet() ? 'Tablet' : 'Desktop'),
              'os' => $this->getOS($userAgent),
              'browser' => $this->getBrowser($userAgent),
              'brand' => $this->getDeviceBrand($userAgent),
              'user_agent' => $userAgent,
              'created_at' => now(),
              'updated_at' => now(),
          ];
      
          // Manually insert the notification into the table
          DB::table('notifications')->insert($notificationDetails);
      
          return redirect()->back()->with('success', 'Shipment method added successfully');
      }
      

// Update an existing shipment method
public function updateShipmentMethod(Request $request, $id)
{
    // Validate the input
    $validator = Validator::make($request->all(), [
        'method_name' => 'required|unique:shipment_methods,method_name,' . $id
    ]);

    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }

    // Find the shipment method
    $method = ShipmentMethod::findOrFail($id);

    // Store the original data before update
    $originalData = $method->toArray();

    // Update the shipment method
    $method->method_name = $request->method_name;
    $method->save();

    // Prepare notification data for the updated shipment method
    $notificationUpdateData = [
        'title' => 'Shipment Method Updated',
        'message' => 'A shipment method has been updated.',
        'details' => [
            'method_name' => $method->method_name,
            'method_id' => $method->id,
            'changes' => $this->getChangedFields($originalData, $method->toArray()), // Get changes made
        ],
    ];

    // Get device and browser details
    $detect = new \Detection\MobileDetect;
    $userAgent = request()->header('User-Agent');

    $notificationDetails = [
        'id' => Str::uuid(),
        'type' => 'App\\Notifications\\ShipmentMethodActivity', // Notification type
        'notifiable_type' => ShipmentMethod::class, // Associated with ShipmentMethod model
        'notifiable_id' => $method->id, // Shipment method ID
        'user_id' => auth()->id(), // Authenticated user ID
        'data' => json_encode($notificationUpdateData),
        'device_type' => $detect->isMobile() ? 'Mobile' : ($detect->isTablet() ? 'Tablet' : 'Desktop'),
        'os' => $this->getOS($userAgent),
        'browser' => $this->getBrowser($userAgent),
        'brand' => $this->getDeviceBrand($userAgent),
        'user_agent' => $userAgent,
        'created_at' => now(),
        'updated_at' => now(),
    ];

    // Manually insert the notification into the table
    DB::table('notifications')->insert($notificationDetails);

    return redirect()->back()->with('success', 'Shipment method updated successfully');
}


// Delete a shipment method
public function deleteShipmentMethod($id)
{
    // Find the shipment method
    $method = ShipmentMethod::findOrFail($id);

    // Store the original data before deletion
    $originalData = $method->toArray();

    // Permanently delete the shipment method
    $method->delete();

    // Prepare notification data for the deleted shipment method
    $notificationDeleteData = [
        'title' => 'Shipment Method Deleted',
        'message' => 'A shipment method has been permanently deleted.',
        'details' => [
            'method_name' => $method->method_name,
            'method_id' => $method->id,
        ],
    ];

    // Get device and browser details
    $detect = new \Detection\MobileDetect;
    $userAgent = request()->header('User-Agent');

    $notificationDetails = [
        'id' => Str::uuid(),
        'type' => 'App\\Notifications\\ShipmentMethodActivity', // Notification type
        'notifiable_type' => ShipmentMethod::class, // Associated with ShipmentMethod model
        'notifiable_id' => $method->id, // Shipment method ID
        'user_id' => auth()->id(), // Authenticated user ID
        'data' => json_encode($notificationDeleteData),
        'device_type' => $detect->isMobile() ? 'Mobile' : ($detect->isTablet() ? 'Tablet' : 'Desktop'),
        'os' => $this->getOS($userAgent),
        'browser' => $this->getBrowser($userAgent),
        'brand' => $this->getDeviceBrand($userAgent),
        'user_agent' => $userAgent,
        'created_at' => now(),
        'updated_at' => now(),
    ];

    // Manually insert the notification into the table
    DB::table('notifications')->insert($notificationDetails);

    return redirect()->back()->with('success', 'Shipment method deleted successfully');
}


// Store a new destination country
public function storeDestinationCountry(Request $request)
{
    // Validate the incoming data
    $validator = Validator::make($request->all(), [
        'country_name' => 'required|unique:destination_countries,country_name',
    ]);

    // If validation fails, redirect back with the errors and input
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Create a new destination country
    $country = new DestinationCountry();
    $country->country_name = $request->country_name;
    $country->save();

    // Prepare notification data for the newly created destination country
    $notificationData = [
        'title' => 'Destination Country Created',
        'message' => 'A new destination country has been created successfully.',
        'details' => [
            'country_name' => $country->country_name,
            'country_id' => $country->id,
        ],
    ];

    // Get device and browser details
    $detect = new \Detection\MobileDetect;
    $userAgent = request()->header('User-Agent');

    $notificationDetails = [
        'id' => Str::uuid(),
        'type' => 'App\\Notifications\\DestinationCountryActivity', // Notification type
        'notifiable_type' => DestinationCountry::class, // Associated with DestinationCountry model
        'notifiable_id' => $country->id, // Destination country ID
        'user_id' => auth()->id(), // Authenticated user ID
        'data' => json_encode($notificationData),
        'device_type' => $detect->isMobile() ? 'Mobile' : ($detect->isTablet() ? 'Tablet' : 'Desktop'),
        'os' => $this->getOS($userAgent),
        'browser' => $this->getBrowser($userAgent),
        'brand' => $this->getDeviceBrand($userAgent),
        'user_agent' => $userAgent,
        'created_at' => now(),
        'updated_at' => now(),
    ];

    // Manually insert the notification into the table
    DB::table('notifications')->insert($notificationDetails);

    // Redirect to the destination countries index route with a success message
    return redirect()->back()->with('success', 'Destination country created successfully.');
}


 // Update an existing destination country
 public function updateDestinationCountry(Request $request, $id)
{
    // Validate the request data
    $validator = Validator::make($request->all(), [
        'country_name' => 'required|unique:destination_countries,country_name,' . $id
    ]);

    // If validation fails, redirect back with errors
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Find the country by ID or return to the previous page with an error message
    $country = DestinationCountry::find($id);

    if (!$country) {
        // Country not found, redirect back with error message
        return redirect()->back()->with('error', 'Destination country not found.');
    }

    // Store the original data to track changes
    $originalData = $country->toArray();

    // Update the country name
    $country->country_name = $request->country_name;
    $country->save();

    // Prepare notification data for the updated destination country
    $notificationData = [
        'title' => 'Destination Country Updated',
        'message' => 'The destination country information has been updated.',
        'details' => [
            'country_name' => $country->country_name,
            'country_id' => $country->id,
        ],
    ];

    // Get device and browser details
    $detect = new \Detection\MobileDetect;
    $userAgent = request()->header('User-Agent');

    $notificationDetails = [
        'id' => Str::uuid(),
        'type' => 'App\\Notifications\\DestinationCountryActivity', // Notification type
        'notifiable_type' => DestinationCountry::class, // Associated with DestinationCountry model
        'notifiable_id' => $country->id, // Destination country ID
        'user_id' => auth()->id(), // Authenticated user ID
        'data' => json_encode($notificationData),
        'device_type' => $detect->isMobile() ? 'Mobile' : ($detect->isTablet() ? 'Tablet' : 'Desktop'),
        'os' => $this->getOS($userAgent),
        'browser' => $this->getBrowser($userAgent),
        'brand' => $this->getDeviceBrand($userAgent),
        'user_agent' => $userAgent,
        'created_at' => now(),
        'updated_at' => now(),
    ];

    // Manually insert the notification into the table
    DB::table('notifications')->insert($notificationDetails);

    // Redirect back with success message
    return redirect()->back()->with('success', 'Destination country updated successfully.');
}




 // Delete a destination country
 public function deleteDestinationCountry($id)
{
    // Find the country by ID or return to the previous page with an error message
    $country = DestinationCountry::find($id);

    if (!$country) {
        // Country not found, redirect back with error message
        return redirect()->back()->with('error', 'Destination country not found.');
    }

    // Store the country name and ID before deletion for the notification
    $countryName = $country->country_name;
    $countryId = $country->id;

    // Permanently delete the country
    $country->delete();

    // Prepare notification data for the deletion of the destination country
    $notificationData = [
        'title' => 'Destination Country Deleted',
        'message' => 'A destination country has been permanently deleted.',
        'details' => [
            'country_name' => $countryName,
            'country_id' => $countryId,
        ],
    ];

    // Get device and browser details
    $detect = new \Detection\MobileDetect;
    $userAgent = request()->header('User-Agent');

    $notificationDetails = [
        'id' => Str::uuid(),
        'type' => 'App\\Notifications\\DestinationCountryActivity', // Notification type
        'notifiable_type' => DestinationCountry::class, // Associated with DestinationCountry model
        'notifiable_id' => $countryId, // Destination country ID
        'user_id' => auth()->id(), // Authenticated user ID
        'data' => json_encode($notificationData),
        'device_type' => $detect->isMobile() ? 'Mobile' : ($detect->isTablet() ? 'Tablet' : 'Desktop'),
        'os' => $this->getOS($userAgent),
        'browser' => $this->getBrowser($userAgent),
        'brand' => $this->getDeviceBrand($userAgent),
        'user_agent' => $userAgent,
        'created_at' => now(),
        'updated_at' => now(),
    ];

    // Manually insert the notification into the table
    DB::table('notifications')->insert($notificationDetails);

    // Redirect back with success message
    return redirect()->back()->with('success', 'Destination country deleted successfully.');
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
