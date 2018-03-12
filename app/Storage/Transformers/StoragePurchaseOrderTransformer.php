<?php

namespace App\Storage\Transformers;

use App\Storage\Models\StorageItems;
use App\Storage\Models\StoragePurchaseOrders;
use App\Storage\Models\StorageRequisition;
use App\Storage\Models\StorageWarehouses;
use App\Traits\GlobalUtils;
use Illuminate\Support\Facades\Log;
use League\Fractal\TransformerAbstract;

class StoragePurchaseOrderTransformer extends TransformerAbstract
{
    use GlobalUtils;

//    protected $defaultIncludes = [
//        'purchaseOrderItems'
//    ];

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
            'withTaxInvoice' => $purchaseOrders->withTaxInvoice,
            'npwpNumber' => $purchaseOrders->npwpNumber,
            'taxFeeAdded' => $purchaseOrders->taxFeeAdded,
            'taxFee' => $purchaseOrders->taxFee,
            'shippingFeeAdded' => $purchaseOrders->shippingFeeAdded,
            'shippingFee' => $purchaseOrders->shippingFee,
            'total' => $purchaseOrders->total,
            'currencyFormat' => $purchaseOrders->currencyFormat,
            'notes' => $purchaseOrders->notes,
            'status' => $this->getResultWithNullChecker1Connection($purchaseOrders, 'status', 'name'),
            'insertedAt' => $purchaseOrders->insertedAt,
            'insertedBy' => $purchaseOrders->insertedBy,
        ];
    }

    public function includePurchaseOrderItems(StoragePurchaseOrders $purchaseOrders)
    {
        $items = $purchaseOrders->purchaseOrderItems;
        return $this->collection($items, new StoragePurchaseOrderItemTransformer, 'items');
    }

}
