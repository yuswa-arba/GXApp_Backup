<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Init backendV1 routes
|--------------------------------------------------------------------------
*/

$backend_path = 'routes/backendV1/';
$type_android = 'android/';
$type_helpdesk = 'helpdesk/';


/*
|--------------------------------------------------------------------------
| Init Helpdesk API routes
|--------------------------------------------------------------------------
*/

require(base_path($backend_path . $type_helpdesk . 'settings/main.php'));
require(base_path($backend_path . $type_helpdesk . 'employee.php'));



/*
|--------------------------------------------------------------------------
| Init Android API routes
|--------------------------------------------------------------------------
*/
require(base_path($backend_path . $type_android . 'auth.php'));




