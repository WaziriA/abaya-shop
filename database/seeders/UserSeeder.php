<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Hash;
use App\Notifications\SendPasswordNotification;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $password = Str::random(8); // Set any length for the password

        // Create the admin user
        
            $adminDetails=   [
                'email' => 'wmussa55@gmail.com',
                'name' => 'Waziri AM',
                'gender' => 'male',
                'country' => 'Tanzania', // Provide country field
                'phone_no' => '0627370387',
                'phone_no2' => '077858558',
                'role' => 'owner',
                'password' => Hash::make($password),
                'IsActive' => true,
            ];

            
            

             // Create the admin user and store it in a variable
         // Create the admin user and store it in a variable
         $user = User::create($adminDetails);

         // Send the password notification, passing the temporary password
         $user->notify(new SendPasswordNotification($user, $password)); // Use the correct notification class

        // Send the password reset notification, passing the temporary password
        //Notification::send($user, new SendPasswordResetLink($user, $password));
        // Send the password to the user using the SendPasswordNotification
        //$user->notify(new SendPasswordNotification($user, $password));
    }
    
}
