<?php

namespace App\Http\Controllers\Vend;

use App\Http\Requests;
use App\VendAuth;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Notifications\JsonNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class VendController extends Controller
{
    public function getToken()
    {

        $code    = Input::get( 'code' );
        $user_id = Input::get( 'state' );

        $url = "https://mayacreative.vendhq.com/api/1.0/token";

        $client = new Client();
        $res    = $client->request( 'POST', $url, [
            'form_params' => [
                "code"          => $code,
                "client_id"     => env('VEND_CLIENT_ID'),
                "client_secret" => env('VEND_CLIENT_SECRET'),
                "grant_type"    => 'authorization_code',
                "redirect_uri"  => env('VEND_REDIRECT_URI'),
            ]
        ] );


        $body    = $res->getBody();
        $decoded = json_decode( $body );

        //echo $body;

        $vend_auth = new VendAuth();

        $vend_auth->user_id       = $user_id;
        $vend_auth->access_token  = $decoded->access_token;
        $vend_auth->token_type    = $decoded->token_type;
        $vend_auth->expires       = $decoded->expires;
        $vend_auth->expires_in    = $decoded->expires_in;
        $vend_auth->refresh_token = $decoded->refresh_token;
        $vend_auth->domain_prefix = $decoded->domain_prefix;

        $vend_auth->save();

        return '<h1>Vend Connected</h1>';
    }

    public function getUserVendAuth($user_id){
        $vend_auth = (new VendAuth)->getVendAuth($user_id);

        return (new JsonNotification)->succeed('Returning Stored Vend Auth',$vend_auth)->notify();
    }

    public function getVendAppCredentials(){

        $credentials = [
            "client_id"     => env('VEND_CLIENT_ID'),
            "redirect_uri"  => env('VEND_REDIRECT_URI'),
        ];

        return (new JsonNotification)->succeed('Returning Vend Credentials from env settings',$credentials)->notify();
    }

    public function getVendProducts(){

        $user = \Auth::user();

        $vend_auth = (new VendAuth)->getVendAuth($user->id);

        $url = "https://{$vend_auth->domain_prefix}.vendhq.com/api/products";

        //return (new JsonNotification)->succeed('DEBUG',$vend_auth->access_token)->notify();

        $client = new Client();
        $res    = $client->request( 'GET', $url,[
            'headers' => [
                'Authorization' => "Bearer {$vend_auth->access_token}",
                'Accept'     => 'application/json',
            ]
        ]);

        $body    = $res->getBody();
        $decoded = json_decode( $body );

        return (new JsonNotification())->succeed('Returning all Vend products',$decoded)->notify();
    }
}