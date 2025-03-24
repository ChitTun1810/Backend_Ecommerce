<?php

namespace App\Classes;

use GuzzleHttp\Client;
use App\Models\UserDevice;
use App\Models\UserToken;

class FirebaseNotification
{

    public function handle($title, $body, $action_link = null)
    {
        $firebaseToken = UserToken::pluck('token')->all();

        if (count($firebaseToken) > 0) {
            $data = [
                "registration_ids" => $firebaseToken,
                "notification"     => [
                    "title" => $title,
                    "body"  => $body,
                ],
                "data"             => [
                    "admin_link" => $action_link,
                ],
            ];

            $this->send($data);
        }
    }

    public function send($data)
    {
        $data['notification']['icon'] = asset('logo.png');

        $SERVER_API_KEY = config('app.firebase_key');

        $client = new Client();

        $client->post('https://fcm.googleapis.com/fcm/send', [
            'headers' => [
                'Authorization' => 'key=' . $SERVER_API_KEY,
                'Content-Type'  => 'application/json',
            ],
            'json'    => $data, // Automatically converts to JSON
            'verify'  => false, // Disables SSL verification (you may remove this if SSL verification is necessary)
        ]);
    }
}
