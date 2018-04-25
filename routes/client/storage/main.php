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

    Route::get('inventory/entry','ViewController@entry')->name('storage.inventory.entry');
    Route::get('inventory/items','ViewController@generalInventory')->name('storage.inventory.items');
    Route::get('inventory/items/general','ViewController@generalInventory')->name('storage.inventory.items.general');
    Route::get('inventory/items/testing','ViewController@testingInventory')->name('storage.inventory.items.testing');
    Route::get('inventory/items/company','ViewController@companyInventory')->name('storage.inventory.items.company');
    Route::get('inventory/items/employee','ViewController@employeeInventory')->name('storage.inventory.items.employee');
    Route::get('inventory/items/customer','ViewController@customerInventory')->name('storage.inventory.items.customer');
    Route::get('inventory/items/sales','ViewController@salesInventory')->name('storage.inventory.items.sales');
    Route::get('inventory/forms','ViewController@inventoryForms')->name('storage.inventory.forms');


});
