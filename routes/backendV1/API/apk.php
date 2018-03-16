<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 19/12/17
 * Time: 8:32 AM
 */

/* v1/a = version 1 Android API */
use Illuminate\Support\Facades\Route;

Route::prefix('v1/a')->middleware('guest')->group(function () {

   Route::namespace('BackendV1\API\Apk')->prefix('apk')->group(function(){
       Route::get('check/latest/version','MainController@checkLatestVersion');
       Route::get('download','MainController@download');
   });

});
