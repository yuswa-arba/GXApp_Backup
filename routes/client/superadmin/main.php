<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 6/11/17
 * Time: 2:12 PM
 */

use Illuminate\Support\Facades\Route;


/*
 |--------------------------------------------------------------------------
 | Superadmin Route
 |--------------------------------------------------------------------------
 */

Route::prefix('superadmin')->namespace('Client\SuperAdmin')->group(function () {

    Route::get('/','ViewController@index')->name('superadmin.index');
    Route::get('login','ViewController@index')->name('superadmin.login');
    Route::get('logout','ViewController@logout')->name('superadmin.logout');
    Route::get('recruitment','ViewController@recruitment')->name('superadmin.recruitment');

});
