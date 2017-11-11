<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 9/11/17
 * Time: 12:22 PM
 */

use Illuminate\Support\Facades\Route;

Route::prefix('passport')->group(function () {

    Route::get('/', 'Passport\ViewController@index')->name('setting.passport');

});
