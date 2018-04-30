<?php


use App\Attendance\Models\AttendanceSchedule;
use App\Fingerspot\Model\FingerspotDevice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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
require(base_path($client_path . 'manager/main.php'));
require(base_path($client_path . 'settings/main.php'));
require(base_path($client_path . 'attendance/main.php'));
require(base_path($client_path . 'doorAccess/main.php'));
require(base_path($client_path . 'developer/main.php'));
require(base_path($client_path . 'salary/main.php'));
require(base_path($client_path . 'misc/main.php'));
require(base_path($client_path . 'profile/main.php'));
require(base_path($client_path . 'storage/main.php'));

/*
|--------------------------------------------------------------------------
| Init Backend routes
|--------------------------------------------------------------------------
*/
require(base_path($backend_path . $type_helpdesk . 'setting.php'));
require(base_path($backend_path . $type_helpdesk . 'employee.php'));
require(base_path($backend_path . $type_helpdesk . 'manager.php'));
require(base_path($backend_path . $type_helpdesk . 'attendance.php'));
require(base_path($backend_path . $type_helpdesk . 'salary.php'));
require(base_path($backend_path . $type_helpdesk . 'developer.php'));
require(base_path($backend_path . $type_helpdesk . 'component.php'));
require(base_path($backend_path . $type_helpdesk . 'misc.php'));
require(base_path($backend_path . $type_helpdesk . 'profile.php'));
require(base_path($backend_path . $type_helpdesk . 'storage.php'));
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

    Route::get('seedCalendar', 'TestUploadController@seedCalendar');
    Route::get('attdlogic', 'TestUploadController@attdLogic');
    Route::get('tryLogic', 'TestUploadController@tryLogic');
    Route::get('SEP', 'TestUploadController@slotEmployeePivot');
    Route::get('efs', 'TestUploadController@employeeFromSlot');
    Route::get('istimegt', 'TestUploadController@isTimeGT');
    Route::get('gd', 'TestUploadController@generateDate');
    Route::get('bin', function () {

        $rawBytes = "";
        foreach (str_split(base64_decode(Storage::get('binary/raw.txt'))) as $byte) {
            $rawBytes .= ' ' . sprintf("%08b", ord($byte));
        }
        return base64_decode(Storage::get('binary/raw.txt'));
    });

    Route::get('broadcast', 'TestUploadController@broadcast');
    Route::get('rn/{length}', 'TestUploadController@randomNumber');
    Route::get('cbdiff','TestUploadController@cbdiff');
    Route::get('dayoff','TestUploadController@dayoff');
    Route::get('pluck','TestUploadController@pluck');

    Route::get('td','TestUploadController@td');

    Route::get('num',function(){

        $device = FingerspotDevice::find(1);
        if ($device) {
            $sn = "sn=" . $device->device_sn;
            $port = $device->server_port;
            $url = $device->server_ip . "/user/set";

            $temp = '[{"pin":"' . '180201007' . '","idx":"' . '0' .
                '","alg_ver":"' . '39' . '","template":"' . '' . '"}]';

            $temp =  str_replace("+", "%2B", $temp);

            $param = array(
                'sn' => $device->device_sn,
                'PIN' => '180201007',
                'nama' => 'Budi' . ' ' . 'abc',
                'pwd'=>0,
                'rfid'=>0,
                'priv'=>0,
            );

            // add empty t
            $param =  http_build_query($param).'&tmp='.$temp;

//            $output = $this->sendRequest($url, $port, http_build_query($param));

            $curl = curl_init();
            set_time_limit(0);
            curl_setopt_array($curl, array(
                    CURLOPT_PORT => $port,
                    CURLOPT_URL => "http://" . $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => $param,
                    CURLOPT_HTTPHEADER => array(
                        "cache-control: no-cache",
                        "content-type: application/x-www-form-urlencoded"
                    ),
                )
            );
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);

            if ($err) {
                $response = ("Error #:" . $err);
            }

            return $response;

        }

    });


});


