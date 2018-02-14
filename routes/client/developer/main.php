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

Route::prefix('developer')->namespace('Client')->group(function () {
    Route::get('/', 'Developer\ViewController@index')->name('developer');
    Route::get('/face', 'Developer\ViewController@face')->name('developer.face');
    Route::get('/logs', 'Developer\ViewController@logs')->name('developer.logs');
    Route::get('/queueJob', 'Developer\ViewController@queueJob')->name('developer.queueJob');
    Route::get('/test','Developer\ViewController@test')->name('developer.test');
});