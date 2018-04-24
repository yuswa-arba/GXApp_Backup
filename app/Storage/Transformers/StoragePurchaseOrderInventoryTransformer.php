<?php

namespace App\Storage\Transformers;

use App\Storage\Models\StorageEntryInventoryHistory;
use App\Storage\Models\StoragePurchaseOrderItems;
use App\Storage\Models\StoragePurchaseOrders;
use App\Traits\GlobalUtils;
use League\Fractal\TransformerAbstract;

class StoragePurchaseOrderInventoryTransformer extends TransformerAbstract
{
    use GlobalUtils;

    protected $availableIncludes = [
        'purchaseOrderItems'
    ];

    public function transform(StoragePurchaseOrders $purchaseOrders)
    {
        return [
            'id' => $purchaseOrders->id,
            'purchaseOrderNumber' => $purchaseOrders->purchaseOrderNumber,
            'withRequisition' => $purchaseOrders->withRequisition,
            'requisitioner'=>$this->getResultWithNullChecker1Connection($purchaseOrders,'requisition','requestedBy'),
            'requisitionNumber' => $this->getResultWithNullChecker1Connection($purchaseOrders, 'requisition', 'requisitionNumber'),
            'approvalNumber' => $this->getResultWithNullChecker1Connection($purchaseOrders, 'requisition', 'approvalNumber'),
            'date' => $purchaseOrders->date,
            'supplierName' => $this->getResultWithNullChecker1Connection($purchaseOrders, 'supplier', 'name'),
            'contactPerson' => $purchaseOrders->contactPerson,
            'contactNumber' => $purchaseOrders->contactNumber,
            'warehouseName' => $this->getResultWithNullChecker1Connection($purchaseOrders, 'warehouse', 'name'),
            'recipientName' => $purchaseOrders->recipientName,
            'recipientNumber' => $purchaseOrders->recipientNumber,
            'deliveryTerm' => $this->getResultWithNullChecker1Connection($purchaseOrders,'deliveryTerm','name'),
            'shippingVia' => $purchaseOrders->shippingVia,
            'shippingMark' =>$purchaseOrders->shippingMark,
            'paymentTerm' => $this->getResultWithNullChecker1Connection($purchaseOrders,'paymentTerm','name'),
            'notes' => $purchaseOrders->notes,
            'statusId'=>$purchaseOrders->statusId,
            'status' => $this->getResultWithNullChecker1Connection($purchaseOrders, 'status', 'name'),
            'insertedAt' => $purchaseOrders->insertedAt,
            'insertedBy' => $purchaseOrders->insertedBy,
        ];
    }

    public function includePurchaseOrderItems(StoragePurchaseOrders $purchaseOrders)
    {
        $items = $purchaseOrders->purchaseOrderItems;
        return $this->collection($items, new StoragePurchaseOrderInventoryItemTransformer, 'items');
    }


}
