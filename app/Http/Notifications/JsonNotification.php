<?php

namespace App\Http\Notifications;

class JsonNotification
{
    public $success;
    public $message;
    public $payload;
    public $http_code;
    public $headers = [
        'Content-Type' => 'application/json; charset=UTF-8',
        'charset'      => 'utf-8'
    ];

    public function succeed( $message = 'No message', $payload = [])
    {
        $this->success = true;
        $this->message = $message;
        $this->payload = $payload;
        $this->http_code = 200;

        return $this;
    }

    public function fail( $message = 'No message', $payload = [ ], $http_code = 500 )
    {
        $this->success = false;
        $this->message = $message;
        $this->payload = $payload;
        $this->http_code = $http_code;

        return $this;
    }

    public function notify(){
        return response()->json(
            [
                "success" => $this->success,
                "message" => $this->message,
                "payload" => $this->payload
            ],
            $this->http_code,
            $this->headers,
            JSON_UNESCAPED_UNICODE
        );
    }

    public function error( \Exception $exception, $message, $http_code = 500 )
    {
        $this->success = false;
        $this->message = (!empty($message))?$message:$exception->getMessage();
        $this->payload = [
            "file" => $exception->getFile(),
            "line" => $exception->getLine(),
            "trace" => $exception->getTrace()
        ];
        $this->http_code = (!empty($http_code))?$message:$exception->getCode();

        return response()->json(
            [
                "success" => false,
                "message" => $this->message,
                "payload" => $this->payload
            ],
            $this->http_code,
            $this->headers,
            JSON_UNESCAPED_UNICODE
        );
    }
}