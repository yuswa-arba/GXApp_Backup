<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Init backendV1 routes
|--------------------------------------------------------------------------
*/

$backend_path = 'routes/backendV1/';


require(base_path($backend_path . 'auth.php'));
require(base_path($backend_path . 'settings/main.php'));


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
