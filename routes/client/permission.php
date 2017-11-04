<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 30/10/17
 * Time: 8:29 PM
 */


/*
 |--------------------------------------------------------------------------
 | Dashboard Route
 |--------------------------------------------------------------------------
 */
use Illuminate\Support\Facades\Route;

Route::prefix('permission')->namespace('Client')->middleware('auth.admin')->group(function () {
    Route::get('/', 'Permission\ViewController@matrix')->name('permission.role.and.permission.table');
});
