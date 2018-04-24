<?php

namespace App\Storage\Transformers;

use App\Storage\Models\StorageItems;
use App\Storage\Models\StorageWarehouses;
use App\Traits\GlobalUtils;
use League\Fractal\TransformerAbstract;

class StorageItemBriefDetailTransformer extends TransformerAbstract
{
    use GlobalUtils;

    public function transform(StorageItems $storageItems)
    {
        return [
            'id' => $storageItems->id,
            'itemCode' => $storageItems->itemCode,
            'name' => $storageItems->name,
            'unitId'=>$storageItems->unitId,
            'unitFormat' => $this->getResultWithNullChecker1Connection($storageItems, 'unitOfMeasurement', 'format'),
            'statusName'=>$this->getResultWithNullChecker1Connection($storageItems,'itemStatus','name'),
            'photo' => $storageItems->photo,
            'latestSellingPrice'=>$storageItems->latestSellingPrice,
            'latestPurchasedPrice'=>$storageItems->latestPurchasedPrice,
            'finePrice'=>$storageItems->finePrice,
            'requiresSerialNumber'=>$storageItems->requiresSerialNumber,
            'isDeleted' => $storageItems->isDeleted,
            //TODO: return current stock as well
        ];
    }
}
