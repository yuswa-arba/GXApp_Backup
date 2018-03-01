<?php

namespace App\Storage\Transformers;

use App\Storage\Models\StorageItems;
use App\Storage\Models\StorageWarehouses;
use App\Traits\GlobalUtils;
use League\Fractal\TransformerAbstract;

class StorageItemDetailTransformer extends TransformerAbstract
{
    use GlobalUtils;

    public function transform(StorageItems $storageItems)
    {
        return [
            'id' => $storageItems->id,
            'itemCode' => $storageItems->itemCode,
            'name' => $storageItems->name,
            'unitId' => $storageItems->unitId,
            'unitFormat' => $this->getResultWithNullChecker1Connection($storageItems, 'unitOfMeasurement', 'format'),
            'itemTypeCode' => $storageItems->itemTypeCode,
            'categoryCode' => $storageItems->categoryCode,
            'accountingNumber' => $storageItems->accountingNumber,
            'itemNumber' => $storageItems->itemNumber,
            'reminder1' => $storageItems->reminder1,
            'reminder2' => $storageItems->reminder2,
            'minimumStock' => $storageItems->minimumStock,
            'allowNotification' => $storageItems->allowNotification,
            'statusId' => $storageItems->statusId,
            'photo' => $storageItems->photo,
            'isDeleted' => $storageItems->isDeleted,
            'editing'=>false
        ];
    }
}
