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
        Route::get('supplier/list', 'Misc\ListController@supplierList');
        Route::get('warehouse/list', 'Misc\ListController@warehouseList');
        Route::get('unit/list', 'Misc\ListController@unitList');
        Route::get('status/list', 'Misc\ListController@statusList');
        Route::get('approvalStatus/list', 'Misc\ListController@approvaStatuslList');
        Route::get('purchaseOrderStatus/list', 'Misc\ListController@purchaseOrderStatusList');

        Route::post('create/itemCategory', 'Misc\CreateController@createItemCategory');
        Route::post('create/itemType', 'Misc\CreateController@createItemType');
        Route::post('create/supplier', 'Misc\CreateController@createSupplier');
        Route::post('create/warehouse', 'Misc\CreateController@createWarehouse');
        Route::post('create/unit', 'Misc\CreateController@createUnit');

        Route::post('update/itemCategory', 'Misc\UpdateDeleteController@updateItemCategory');
        Route::post('delete/itemCategory', 'Misc\UpdateDeleteController@deleteItemCategory');
        Route::post('undoDelete/itemCategory', 'Misc\UpdateDeleteController@undoDeleteItemCategory');

        Route::post('update/itemType', 'Misc\UpdateDeleteController@updateItemType');
        Route::post('delete/itemType', 'Misc\UpdateDeleteController@deleteItemType');
        Route::post('undoDelete/itemType', 'Misc\UpdateDeleteController@undoDeleteItemType');

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
        Route::post('item/editPrice','Misc\ItemController@editItemPrice');
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
        Route::get('requisition/history/track/detail', 'Requisition\HistoryTrackController@requisitionTrackDetail');
        /*
        |--------------------------------------------------------------------------
        | Requisition Admin Approval
        |--------------------------------------------------------------------------
        */

        Route::get('admin/approval', 'Admin\ApprovalController@requisitionList');
        Route::get('admin/approval/search', 'Admin\ApprovalController@searchRequisitionList');
        Route::post('admin/approval/requisition/approve', 'Admin\ApprovalController@approveRequisition');
        Route::post('admin/approval/requisition/decline', 'Admin\ApprovalController@declineRequisition');
        Route::post('admin/approval/requisition/editAndApprove', 'Admin\ApprovalController@editAndApproveRequisition');

        /*
        |--------------------------------------------------------------------------
        | Requisition Purchase Order
        |--------------------------------------------------------------------------
        */

        Route::get('admin/purchaseOrder/requisition', 'Admin\PurchaseOrderController@availableRequisition');
        Route::get('admin/purchaseOrder/requisition/search', 'Admin\PurchaseOrderController@searchAvailableRequisition');
        Route::get('admin/purchaseOrder/supplier', 'Admin\PurchaseOrderController@supplierList');
        Route::get('admin/purchaseOrder/supplier/search', 'Admin\PurchaseOrderController@searchSupplier');
        Route::get('admin/purchaseOrder/warehouse', 'Admin\PurchaseOrderController@warehouseList');
        Route::get('admin/purchaseOrder/warehouse/search', 'Admin\PurchaseOrderController@searchWarehouse');
        Route::get('admin/purchaseOrder/item/search', 'Admin\PurchaseOrderController@searchItem');
        Route::post('admin/purchaseOrder/create', 'Admin\PurchaseOrderController@createPurchaseOrder');
        Route::get('admin/purchaseOrder/list', 'Admin\PurchaseOrderController@purchaseOrderList');
        Route::get('admin/purchaseOrder/search', 'Admin\PurchaseOrderController@searchPurchaseOrder');
        Route::get('admin/purchaseOrder/detail', 'Admin\PurchaseOrderController@purchaseOrderDetail');
        Route::post('admin/purchaseOrder/update/status', 'Admin\PurchaseOrderController@updatePurchaseOrder');
        Route::get('admin/purchaseOrder/generate/pdf', 'Admin\PurchaseOrderController@generatePDF');
        Route::get('admin/purchaseOrder/approvalDetail', 'Admin\PurchaseOrderController@getApprovalDetail');
        Route::post('admin/purchaseOrder/item/track/add', 'Admin\PurchaseOrderController@addItemTrack');

        /*
          |--------------------------------------------------------------------------
          | Storage Inventory
          |--------------------------------------------------------------------------
          */

        Route::get('inventory/purchaseOrder/detail', 'Inventory\InsertToInventoryController@purchaseOrderInventoryDetail');
        Route::post('inventory/entry', 'Inventory\InsertToInventoryController@entry');
        Route::get('inventory/general/list','Inventory\GeneralInventoryController@getList');

    });
});