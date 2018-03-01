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
 | Storage Route
 |--------------------------------------------------------------------------
 */

Route::prefix('storage')->namespace('Client\Storage')->group(function () {

    Route::get('misc/items', 'ViewController@items')->name('storage.misc.items');
    Route::get('misc/itemCategories', 'ViewController@itemCategories')->name('storage.misc.itemCategories');
    Route::get('misc/itemTypes', 'ViewController@itemTypes')->name('storage.misc.itemTypes');
    Route::get('misc/shipments', 'ViewController@shipments')->name('storage.misc.shipments');
    Route::get('misc/suppliers', 'ViewController@suppliers')->name('storage.misc.suppliers');
    Route::get('misc/warehouses', 'ViewController@warehouses')->name('storage.misc.warehouses');
    Route::get('misc/units', 'ViewController@units')->name('storage.misc.units');

    Route::get('requisition/shop','ViewController@requisitionShop')->name('storage.requisition.shop');

});
