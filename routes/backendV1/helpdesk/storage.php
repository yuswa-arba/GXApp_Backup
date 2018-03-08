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
        Route::get('status/list', 'Misc\ListController@statusList');
        Route::get('approvalStatus/list','Misc\ListController@approvaStatuslList');

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

        Route::post('update/supplier', 'Misc\UpdateDeleteController@updateSupplier');
        Route::post('delete/supplier', 'Misc\UpdateDeleteController@deleteSupplier');
        Route::post('undoDelete/supplier', 'Misc\UpdateDeleteController@undoDeleteSupplier');

        /*
         |--------------------------------------------------------------------------
         | Misc Item
         |--------------------------------------------------------------------------
         */
        Route::get('item/list', 'Misc\ItemController@itemList');
        Route::post('create/item', 'Misc\ItemController@createItem');
        Route::post('delete/item', 'Misc\ItemController@deleteItem');
        Route::post('undoDelete/item', 'Misc\ItemController@undoDeleteItem');

        /*
        |--------------------------------------------------------------------------
        | Requisition Shop
        |--------------------------------------------------------------------------
        */
        Route::get('requisition/shop/item/list', 'Shop\ShopController@itemList');
        Route::get('requisition/shop/item/detail', 'Shop\ShopController@itemDetail');
        Route::get('requisition/shop/item/search', 'Shop\ShopController@searchItem');

        /*
        |--------------------------------------------------------------------------
        | Requisition Shop Cart
        |--------------------------------------------------------------------------
        */
        Route::get('requisition/shop/cart/totalItemInCart', 'Cart\CartController@getTotalItemInCart');
        Route::post('requisition/shop/cart/add', 'Cart\CartController@addToCart');
        Route::post('requisition/shop/cart/remove', 'Cart\CartController@removeFromCart');
        Route::post('requisition/shop/cart/removeAll', 'Cart\CartController@removeAllFromCart');
        Route::get('requisition/shop/cart/list', 'Cart\CartController@itemInsideCartList');
        Route::post('requisition/shop/cart/updateItemAmountInCart', 'Cart\CartController@updateItemAmountInCart');
        Route::post('requisition/shop/cart/updateItemNotesInCart', 'Cart\CartController@updateItemNotesInCart');

        /*
        |--------------------------------------------------------------------------
        | Requisition
        |--------------------------------------------------------------------------
        */
        Route::post('requisition/itemBeingRequested/list', 'Requisition\RequisitionController@itemsBeingRequestedList');
        Route::post('requisition/create', 'Requisition\RequisitionController@createRequisition');

        /*
       |--------------------------------------------------------------------------
       | Requisition History
       |--------------------------------------------------------------------------
       */

        Route::get('requisition/history', 'Requisition\HistoryTrackController@requisitionHistory');
        Route::get('requisition/history/search', 'Requisition\HistoryTrackController@searchRequisitionHistory');

        /*
        |--------------------------------------------------------------------------
        | Requisition Admin Approval
        |--------------------------------------------------------------------------
        */

        Route::get('admin/approval','Admin\ApprovalController@requisitionList');
        Route::get('admin/approval/search', 'Admin\ApprovalController@searchRequisitionList');
        Route::post('admin/approval/requisition/approve','Admin\ApprovalController@approveRequisition');
        Route::post('admin/approval/requisition/decline','Admin\ApprovalController@declineRequisition');
        Route::post('admin/approval/requisition/editAndApprove','Admin\ApprovalController@editAndApproveRequisition');

        /*
        |--------------------------------------------------------------------------
        | Requisition Purchase Order
        |--------------------------------------------------------------------------
        */
        Route::get('admin/purchaseOrder/requisition','Admin\PurchaseOrderController@availableRequisition');
        Route::get('admin/purchaseOrder/requisition/search','Admin\PurchaseOrderController@searchAvailableRequisition');
        Route::get('admin/purchaseOrder/supplier','Admin\PurchaseOrderController@supplierList');
        Route::get('admin/purchaseOrder/supplier/search','Admin\PurchaseOrderController@searchSupplier');


    });
});