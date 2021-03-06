<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Init backendV1 routes
|--------------------------------------------------------------------------
*/

$backend_path = 'routes/backendV1/';
$api_path = 'API/';
/*
|--------------------------------------------------------------------------
| Init Android API routes
|--------------------------------------------------------------------------
*/
require(base_path($backend_path . $api_path . 'auth.php'));
require(base_path($backend_path . $api_path . 'apk.php'));
require(base_path($backend_path . $api_path . 'attendance.php'));
require(base_path($backend_path . $api_path . 'salary.php'));
require(base_path($backend_path . $api_path . 'employee.php'));
require(base_path($backend_path . $api_path . 'inbox.php'));




