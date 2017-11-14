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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Path & Type Configuration
|--------------------------------------------------------------------------
*/
$client_path = 'routes/client/';
$backend_path = 'routes/backendV1/';
$type_helpdesk = 'helpdesk/';
/*
|--------------------------------------------------------------------------
| Init client routes
|--------------------------------------------------------------------------
*/
require(base_path($client_path . 'auth.php'));
require(base_path($client_path . 'dashboard.php'));
require(base_path($client_path . 'divisions.php'));
require(base_path($client_path . 'employee.php'));
require(base_path($client_path . 'settings/main.php'));


/*
|--------------------------------------------------------------------------
| Init Backend routes
|--------------------------------------------------------------------------
*/
require(base_path($backend_path . $type_helpdesk . 'settings/main.php'));
require(base_path($backend_path . $type_helpdesk . 'employee.php'));


/*
|--------------------------------------------------------------------------
| Init general routes
|--------------------------------------------------------------------------
*/
Route::get('/', 'Client\Dashboard\ViewController@index');

/*
|--------------------------------------------------------------------------
| Init testing routes
|--------------------------------------------------------------------------
*/

Route::prefix('testing')->middleware('auth.admin')->group(function () {
   Route::get('userevent',function(){
       $user = \App\Account\Models\User::where('email','joko@example.com')->get();
       event(new \App\Employee\Events\UserGenerated($user,'password'));
   });


});


