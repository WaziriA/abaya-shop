<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Detection\MobileDetect; // Include MobileDetect
use App\Models\User;

class UserActivities extends Notification
{
    use Queueable;

    protected $data;

    /**
     * Create a new notification instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase($notifiable)
    {
        $detect = new MobileDetect();
        $userAgent = request()->header('User-Agent');

        return [
            'title' => $this->data['title'],
            'message' => $this->data['message'],
            'data' => $this->data['details'] ?? null,
            'device' => [
                'user_agent' => $userAgent,
                'device_type' => $detect->isMobile() ? 'Mobile' : ($detect->isTablet() ? 'Tablet' : 'Desktop'),
                'os' => $this->getOS($userAgent),
                'browser' => $this->getBrowser($userAgent),
                'brand' => $this->getDeviceBrand($userAgent),
            ],
        ];
    }

    /**
     * Parse the operating system from the user agent.
     */
    private function getOS($userAgent)
    {
        if (preg_match('/windows nt/i', $userAgent)) return 'Windows';
        if (preg_match('/macintosh|mac os x/i', $userAgent)) return 'MacOS';
        if (preg_match('/linux/i', $userAgent)) return 'Linux';
        if (preg_match('/android/i', $userAgent)) return 'Android';
        if (preg_match('/iphone|ipad|ipod/i', $userAgent)) return 'iOS';
        return 'Unknown OS';
    }

    /**
     * Parse the browser from the user agent.
     */
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
            'Tecno' => '/tecno/i',   // Added Tecno
            'Infinix' => '/infinix/i', // Added Infinix
        ];

        foreach ($brands as $brand => $pattern) {
            if (preg_match($pattern, $userAgent)) {
                return $brand;
            }
        }

        return 'Unknown Brand';
    }

    
    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
