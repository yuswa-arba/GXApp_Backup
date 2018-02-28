<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 6/11/17
 * Time: 4:50 PM
 */


/*
 |--------------------------------------------------------------------------
 | Storage Route
 |--------------------------------------------------------------------------
 */


use Illuminate\Support\Facades\Route;

Route::prefix('v1/h')->group(function () {
//    Route::prefix('storage')->namespace('BackendV1\Helpdesk\Storage')->middleware('auth.admin')->group(function () {
    Route::prefix('storage')->namespace('BackendV1\Helpdesk\Storage')->group(function () {

        /*
         |--------------------------------------------------------------------------
         | Misc
         |--------------------------------------------------------------------------
         */

        Route::get('itemCategory/list', 'Misc\ListController@itemCategoryList');
        Route::get('itemType/list', 'Misc\ListController@itemTypeList');
        Route::get('shipment/list', 'Misc\ListController@shipmentList');
        Route::get('supplier/list', 'Misc\ListController@supplierList');
        Route::get('warehouse/list', 'Misc\ListController@warehouseList');
        Route::get('unit/list', 'Misc\ListController@unitList');

        Route::post('create/itemCategory', 'Misc\CreateController@createItemCategory');
        Route::post('create/itemType', 'Misc\CreateController@createItemType');
        Route::post('create/shipment', 'Misc\CreateController@createShipment');
        Route::post('create/supplier', 'Misc\CreateController@createSupplier');
        Route::post('create/warehouse', 'Misc\CreateController@createWarehouse');
        Route::post('create/unit', 'Misc\CreateController@createUnit');

        Route::post('update/itemCategory', 'Misc\UpdateDeleteController@updateItemCategory');
        Route::post('delete/itemCategory', 'Misc\UpdateDeleteController@deleteItemCategory');
        Route::post('undoDelete/itemCategory', 'Misc\UpdateDeleteController@undoDeleteItemCategory');

        Route::post('update/itemType', 'Misc\UpdateDeleteController@updateItemType');
        Route::post('delete/itemType', 'Misc\UpdateDeleteController@deleteItemType');
        Route::post('undoDelete/itemType', 'Misc\UpdateDeleteController@undoDeleteItemType');

        Route::post('update/shipment', 'Misc\UpdateDeleteController@updateShipment');
        Route::post('delete/shipment', 'Misc\UpdateDeleteController@deleteShipment');
        Route::post('undoDelete/shipment', 'Misc\UpdateDeleteController@undoDeleteShipment');

        Route::post('update/warehouse', 'Misc\UpdateDeleteController@updateWarehouse');
        Route::post('delete/warehouse', 'Misc\UpdateDeleteController@deleteWarehouse');
        Route::post('undoDelete/warehouse', 'Misc\UpdateDeleteController@undoDeleteWarehouse');

        Route::post('update/unit', 'Misc\UpdateDeleteController@updateUnit');
        Route::post('delete/unit', 'Misc\UpdateDeleteController@deleteUnit');
        Route::post('undoDelete/unit', 'Misc\UpdateDeleteController@undoDeleteUnit');
    });
});