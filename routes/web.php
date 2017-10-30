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
$backend_path = 'routes/backend/';

/*
|--------------------------------------------------------------------------
| Init client routes
|--------------------------------------------------------------------------
*/
require(base_path($client_path . 'dashboard.php'));
require(base_path($client_path . 'divisions.php'));


/*
|--------------------------------------------------------------------------
| Init backend routes
|--------------------------------------------------------------------------
*/



/*
|--------------------------------------------------------------------------
| Init general routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});


/*
|--------------------------------------------------------------------------
| Init testing routes
|--------------------------------------------------------------------------
*/


