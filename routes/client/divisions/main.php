<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 30/10/17
 * Time: 8:24 PM
 */

use Illuminate\Support\Facades\Route;

/*
 |--------------------------------------------------------------------------
 | Divisions Route
 |--------------------------------------------------------------------------
 */
Route::prefix('divisions')->namespace('Client')->group(function () {
    /*
    |--------------------------------------------------------------------------
    | CSO
    |--------------------------------------------------------------------------
    */
    Route::prefix('cso')->group(function () {
        Route::get('/', 'Division\Cso\ViewController@index')->name('cso');
    });

    /*
    |--------------------------------------------------------------------------
    | CTSO
    |--------------------------------------------------------------------------
    */
    Route::prefix('ctso')->group(function () {
        Route::get('/', 'Division\Ctso\ViewController@index')->name('ctso');
    });

    /*
    |--------------------------------------------------------------------------
    | Marketing
    |--------------------------------------------------------------------------
    */
    Route::prefix('marketing')->group(function () {
        Route::get('/', 'Division\Marketing\ViewController@index')->name('marketing');
    });

    /*
     |--------------------------------------------------------------------------
     | Fiber Optic
     |--------------------------------------------------------------------------
     */
    Route::prefix('MNT')->group(function () {
        Route::get('/', 'Division\Maintenance\ViewController@index')->name('maintenance');
    });

    /*
    |--------------------------------------------------------------------------
    | Fiber Optic
    |--------------------------------------------------------------------------
    */
    Route::prefix('FO')->group(function () {
        Route::get('/', 'Division\FiberOptic\ViewController@index')->name('fiberoptic');
    });

    /*
    |--------------------------------------------------------------------------
    | Wireless
    |--------------------------------------------------------------------------
    */
    Route::prefix('WL')->group(function () {
        Route::get('/', 'Division\Wireless\ViewController@index')->name('wireless');
    });

    /*
    |--------------------------------------------------------------------------
    | Network Administrator
    |--------------------------------------------------------------------------
    */
    Route::prefix('NA')->group(function () {
        Route::get('/', 'Division\NetworkAdministrator\ViewController@index')->name('na');
    });

    /*
    |--------------------------------------------------------------------------
    | Storage
    |--------------------------------------------------------------------------
    */
    Route::prefix('storage')->group(function () {
        Route::get('/', 'Division\Storage\ViewController@index')->name('storage');
    });

    /*
    |--------------------------------------------------------------------------
    | Household
    |--------------------------------------------------------------------------
    */
    Route::prefix('household')->group(function () {
        Route::get('/', 'Division\Household\ViewController@index')->name('household');
    });


});