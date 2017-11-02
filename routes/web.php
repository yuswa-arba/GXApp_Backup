<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Path Configuration
|--------------------------------------------------------------------------
*/
$client_path = 'routes/client/';
$backend_path = 'routes/backendV1/';

/*
|--------------------------------------------------------------------------
| Init client routes
|--------------------------------------------------------------------------
*/
require(base_path($client_path . 'auth.php'));
require(base_path($client_path . 'dashboard.php'));
require(base_path($client_path . 'divisions.php'));
require(base_path($client_path . 'employee.php'));

/*
|--------------------------------------------------------------------------
| Init backendV1 routes
|--------------------------------------------------------------------------
*/
require(base_path($backend_path . 'auth.php'));

/*
|--------------------------------------------------------------------------
| Init general routes
|--------------------------------------------------------------------------
*/
Route::get('/', 'Client\Dashboard\ViewController@index');
//Route::get('/', function () {
//    if (\Illuminate\Support\Facades\Auth::check()) {
//        echo "login";
//    } else {
//        echo "no user";
//    }
//});

Route::get('invalid', function () {
    echo "invalid";
});
/*
|--------------------------------------------------------------------------
| Init testing routes
|--------------------------------------------------------------------------
*/

Route::prefix('testing')->group(function () {
    Route::get('uuid', function () {

    });
});


