<?php

namespace App\Broadcasting;

use App\Models\User;
use App\Notifications\RegisterNotification;
use App\Services\InforuSMSService;

class SMSChannel
{
    /**
     * Authenticate the user's access to the channel.
     *
     * @param  \App\Models\User  $user
     * @return array|bool
     */
    public function send($notifiable, RegisterNotification $notification)
    {
        $message = $notification->toSMS($notifiable);

        if (config('external-apis.inforu.service_enabled') && $message && strlen($message) > 0 && $notifiable instanceof User) {
            $smsService = new InforuSMSService();
            $smsService->sendMessage($notifiable->phone, $message);
        }
    }
}
