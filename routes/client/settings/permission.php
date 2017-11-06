<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 30/10/17
 * Time: 8:29 PM
 */


/*
 |--------------------------------------------------------------------------
 | Permission Route
 |--------------------------------------------------------------------------
 |   Config :
 |   This route is included in route path -> settings/main.php,
 |   all middleware and prefixes should be in that file already,
 |   but you can customize it anyway you want
 |--------------------------------------------------------------------------
 */

use Illuminate\Support\Facades\Route;


Route::prefix('permission')->group(function () {
    Route::get('/', 'Permission\ViewController@index')->name('setting.permission');
});

