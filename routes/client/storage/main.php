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
    Route::get('misc/suppliers', 'ViewController@suppliers')->name('storage.misc.suppliers');
    Route::get('misc/warehouses', 'ViewController@warehouses')->name('storage.misc.warehouses');
    Route::get('misc/units', 'ViewController@units')->name('storage.misc.units');

    Route::get('requisition/shop','ViewController@requisitionShop')->name('storage.requisition.shop');
    Route::get('requisition/cart','ViewController@requisitionCart')->name('storage.requisition.cart');
    Route::get('requisition/history','ViewController@requisitionHistory')->name('storage.requisition.history');

    Route::middleware('auth.admin')->group(function(){
        Route::get('admin/approval','ViewController@approval')->name('storage.admin.approval');
        Route::get('admin/purchaseOrder','ViewController@purchaseOrder')->name('storage.admin.purchaseOrder');
    });

    Route::get('inventory/entry','ViewController@entryInventory')->name('storage.inventory.entry');
    Route::get('inventory/items','ViewController@inventoryItems')->name('storage.inventory.items');
    Route::get('inventory/forms','ViewController@inventoryForms')->name('storage.inventory.forms');


});
