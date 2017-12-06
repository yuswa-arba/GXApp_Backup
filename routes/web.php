<?php


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
require(base_path($client_path . 'auth/main.php'));
require(base_path($client_path . 'dashboard/main.php'));
require(base_path($client_path . 'divisions/main.php'));
require(base_path($client_path . 'employee/main.php'));
require(base_path($client_path . 'settings/main.php'));
require(base_path($client_path . 'attendance/main.php'));
require(base_path($client_path . 'doorAccess/main.php'));

/*
|--------------------------------------------------------------------------
| Init Backend routes
|--------------------------------------------------------------------------
*/
require(base_path($backend_path . $type_helpdesk . 'settings/main.php'));
require(base_path($backend_path . $type_helpdesk . 'employee.php'));
require(base_path($backend_path . $type_helpdesk . 'attendance.php'));

require(base_path($backend_path . $type_helpdesk . 'component.php'));

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

Route::prefix('testing')->group(function () {

    Route::get('employment', function () {
        $employment = \App\Employee\Models\Employment::find(1);
        echo json_encode($employment->employee);
    });

    Route::get('upload', function () {
        $datas = \Illuminate\Support\Facades\DB::table('test_upload')->select('*')->get();
        return view('pages.testing.upload', compact('datas'));
    })->name('form.upload');

    Route::post('upload', 'TestUploadController@upload')->name('post.upload');

    Route::get('seedCalendar','TestUploadController@seedCalendar');
    Route::get('attdlogic','TestUploadController@attdLogic');
    Route::get('tryLogic','TestUploadController@tryLogic');
    Route::get('SEP','TestUploadController@slotEmployeePivot');

});


