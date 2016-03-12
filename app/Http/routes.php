<?php


/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Public Routes
Route::get( '/get-vend-token', 'Vend\VendController@getToken' );

Route::get("add-user", function(){
//    App\User::create([
//        'name' => 'Brian Gaeddert',
//        'email' => 'bgaeddert@gmail.com',
//        'password' => bcrypt('!QA2ws#ED'),
//    ]);
});



/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/


Route::group(['middleware' => ['cors']], function () {
    Route::get('persons/matches', 'PersonsController@getMatch');
    Route::get('persons/{cedula_id}', 'PersonsController@getPerson');
});

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/', 'HomeController@index');

    Route::get('/users/current', 'UsersController@currentUser');
    Route::get('/vend/auth/{user_id}', 'Vend\VendController@getUserVendAuth');
    Route::get('/vend/products', 'Vend\VendController@getVendProducts');
    Route::get('/vend/public/credentials', 'Vend\VendController@getVendAppCredentials');

    //Route::any( '{url?}', function($url){return \Redirect::to($url);} )->where( [ 'url' => 'app/.+' ] );

    // Catch all route send you to the homeController. (index page)
    Route::any( '{url?}', 'HomeController@index' )->where( [ 'url' => '.+' ] );

});



