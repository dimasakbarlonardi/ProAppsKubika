<?php

namespace App\Helpers;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Appy\FcmHttpV1\FcmGoogleHelper;
use Appy\FcmHttpV1\FcmNotification;

class FCM extends FcmNotification {

    public function setPayload($payload) {
        if(!isset($payload['token']) && !isset($payload['title']) && !isset($payload['title'])){
            throw new Exception("Payload must contain : token, title, and body");
        }

        $empty = [
            'token' => empty($payload['token']),
            'title' => empty($payload['title']),
            'body' => empty($payload['body']),
        ];

        if(!$empty['token']) {
            $this->token = $payload['token'];
        }
        if(!$empty['title']) {
            $this->title = $payload['title'];
        }
        if(!$empty['body']) {
            $this->body = $payload['body'];
        }
        

        return $this;
    }
    /**
     * Verify the conformity of the notification. If everything is ok, send the notification.
     */
    public function send()
    {
        // Token and topic combinaison verification
        if ($this->token != null && $this->topic != null) {
            throw new Exception("A notification need to have at least one target: token or topic. Please select only one type of target.");
        }

        // Empty token or topic verification
        if ($this->token == null && $this->topic == null) {
            throw new Exception("A notification need to have at least one target: token or topic. Please add a target using setToken() or setTopic().");
        }

        if ($this->token != null && !is_string($this->token)) {
            throw new Exception('Token format error. Received: ' . gettype($this->token) . ". Expected type: string");
        }

        // Title verification
        if (!isset($this->title)) {
            throw new Exception('Empty notification title. Please add a title to the notification with the setTitle() method.');
        }

        // Body verification
        if (!isset($this->body)) {
            throw new Exception('Empty notification body. Please add a body to the notification with the setBody() method');
        }

        // Icon verification
        if ($this->icon !=null && !file_exists(public_path($this->icon))) {
            throw new Exception("Icon not found. Please verify the path of your icon(Path of the icon you tried to set: " . asset($this->icon));
        }

        return $this->prepareSend();
    }
    
    private function prepareSend()
    {
        if (isset($this->topic)) {
            $data = [
                "message" => [
                    "topic" => $this->topic,
                    "android" => [
                        "priority" => "high",
                        "notification" => [
                            "title" => $this->title,
                            "body" => $this->body,
                            "icon" => $this->icon !=null ? asset($this->icon) : '',
                            "click_action" => $this->click_action ?? ''
                        ],
                    ]
                ]
            ];
        } elseif (isset($this->token)) {
            $data = [
                "message" => [
                    "token" => $this->token,
                    "android" => [
                        "priority" => "high",
                        "notification" => [
                            "title" => $this->title,
                            "body" => $this->body,
                            "icon" => $this->icon !=null ? asset($this->icon) : '',
                            "click_action" => $this->click_action ?? ''
                        ],
                    ]
                ]
            ];
        }

        $encodedData = json_encode($data);

        return $this->handleSend($encodedData);
    }

    private function handleSend($encodedData)
    {
        $url = config('fcm_config.fcm_api_url');

        $oauthToken = FcmGoogleHelper::configureClient();

        $headers = [
            'Authorization' => 'Bearer ' . $oauthToken,
            'Content-Type' =>  'application/json',
        ];

        $client = new Client();

        try {
            $request = $client->post($url, [
                'headers' => $headers,
                "body" => $encodedData,
            ]);

            Log::info("[Notification] SENT", [$encodedData]);

            return $request->getBody();
        } catch (Exception $e) {
            Log::error("[Notification] ERROR", [$e->getMessage()]);

            return $e;
        }
    }
}