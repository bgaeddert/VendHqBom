<?php

namespace App\Http\Controllers;

use App\Http\Notifications\JsonNotification;
use App\Http\Requests;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware( 'auth' );
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view( 'home' );
    }

    public function currentUser()
    {
        $user = \Auth::user();

        return ( new JsonNotification )->succeed( 'Returning Current User', $user )->notify();
    }
}
