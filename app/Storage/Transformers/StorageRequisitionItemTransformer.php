<?php

namespace App\Storage\Transformers;

use App\Storage\Models\StorageItems;
use App\Storage\Models\StorageRequisitionItems;
use App\Storage\Models\StorageWarehouses;
use App\Traits\GlobalUtils;
use League\Fractal\TransformerAbstract;

class StorageRequisitionItemTransformer extends TransformerAbstract
{
    use GlobalUtils;

    public function transform(StorageRequisitionItems $storageRequisitionItems)
    {
        return [
            'id' => $storageRequisitionItems->id,
            'requisitionNumber' =>$this->getResultWithNullChecker1Connection($storageRequisitionItems,'requisition','requisitionNumber'),
            'employeeName' => $this->getResultWithNullChecker1Connection($storageRequisitionItems,'employee','givenName'),
            'itemName' => $this->getResultWithNullChecker1Connection($storageRequisitionItems,'item','name'),
            'itemCode' => $this->getResultWithNullChecker1Connection($storageRequisitionItems,'item','itemCode'),
            'itemPhoto' => $this->getResultWithNullChecker1Connection($storageRequisitionItems,'item','photo'),
            'itemUnit' => $this->getResultWithNullChecker2Connection($storageRequisitionItems, 'item','unitOfMeasurement', 'format'),
            'amount' => $storageRequisitionItems->amount,
            'notes' => $storageRequisitionItems->notes,
            'insertedAt' => $storageRequisitionItems->insertedAt,
            'isApproved' => $storageRequisitionItems->isApproved,
            'updatedAt' => $storageRequisitionItems->updatedAt,
            'updatedBy' => $storageRequisitionItems->updatedBy,
        ];
    }
}
