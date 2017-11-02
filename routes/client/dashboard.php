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

Route::prefix('dashboard')->middleware('auth')->namespace('Client')->group(function () {
    Route::get('/', 'Dashboard\ViewController@index')->name('dashboard');
});
