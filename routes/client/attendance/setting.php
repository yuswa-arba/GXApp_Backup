<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 22/11/17
 * Time: 3:33 PM
 */

use Illuminate\Support\Facades\Route;

Route::prefix('setting')->group(function () {

    Route::get('/', 'ViewController@setting')->name('attendance.setting');

});
