<?php

namespace App\Http\Controllers;

use App\Http\Notifications\JsonNotification;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpFoundation\Response;

class PersonsController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getMatch()
    {
        $_cedula_id   = Input::get( 'id' );
        $_name_1      = Input::get( 'name_1' );
        $_name_2      = Input::get( 'name_2' );
        $_name_3      = Input::get( 'name_3' );
        $_show_person = Input::get( 'show_person' );

        $person = \App\Person::find( $_cedula_id );

        if ( $person )
        {
            $matches = $person->compareNames( $_name_1, $_name_2, $_name_3 );

            $payload["matches"] = $matches;

            if ( $_show_person === 'true' )
            {
                $payload[ 'person' ] = $person;
            }

            return ( new JsonNotification )->succeed( 'Person Found.', $payload )->notify();
        }

        $payload = [
            "matches" => [
                "match_1" => false,
                "match_2" => false,
                "match_3" => false
            ]
        ];

        return ( new JsonNotification )->fail( 'Person Not Found.', $payload )->notify();
    }

    public function getPerson( $cedula_id )
    {
        $person = \App\Person::find( $cedula_id );

        if ( $person )
        {
            return ( new JsonNotification )->succeed( 'Person Found.', [ "person" => $person ] )->notify();
        }

        return ( new JsonNotification )->fail( 'Person Not Found!')->notify();
    }
}
