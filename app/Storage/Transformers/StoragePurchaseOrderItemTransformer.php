<?php

namespace App\Storage\Transformers;

use App\Storage\Models\StorageItems;
use App\Storage\Models\StoragePurchaseOrderItems;
use App\Storage\Models\StorageRequisitionItems;
use App\Storage\Models\StorageWarehouses;
use App\Traits\GlobalUtils;
use League\Fractal\TransformerAbstract;

class StoragePurchaseOrderItemTransformer extends TransformerAbstract
{
    use GlobalUtils;

    public function transform(StoragePurchaseOrderItems $purchaseOrderItems)
    {
        return [
            'id'=>$purchaseOrderItems->id,
            'purchaseOrderId'=>$purchaseOrderItems->purchaseOrderId,
            'purchaseOrderNumber'=>$this->getResultWithNullChecker1Connection($purchaseOrderItems,'purchaseOrder','purchaseOrderNumber'),
            'withRequisitionItem'=>$purchaseOrderItems->withRequisitionItem,
            'requisitionItemId'=>$purchaseOrderItems->requisitionItemId,
            'itemName' => $this->getResultWithNullChecker1Connection($purchaseOrderItems,'item','name'),
            'itemCode' => $this->getResultWithNullChecker1Connection($purchaseOrderItems,'item','itemCode'),
            'itemPhoto' => $this->getResultWithNullChecker1Connection($purchaseOrderItems,'item','photo'),
            'itemUnit' => $this->getResultWithNullChecker2Connection($purchaseOrderItems, 'item','unitOfMeasurement', 'format'),
            'amountPurchased'=>$purchaseOrderItems->amountPurchased,
            'unitIdPurchased'=>$purchaseOrderItems->unitIdPurchased,
            'unitFormatPurchased' => $this->getResultWithNullChecker1Connection($purchaseOrderItems,'unitPurchased', 'format'),
            'hasCustomUnit'=>$purchaseOrderItems->hasCustomUnit,
            'customUnit'=>$purchaseOrderItems->customUnit,
            'pricePurchased'=>$purchaseOrderItems->pricePurchased,
            'currencyFormat'=>$purchaseOrderItems->currencyFormat,
        ];
    }
}
