<?php

namespace App\Storage\Transformers;

use App\Storage\Models\StorageItems;
use App\Storage\Models\StorageWarehouses;
use App\Traits\GlobalUtils;
use League\Fractal\TransformerAbstract;

class StorageItemListTransformer extends TransformerAbstract
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
            'statusId' => $storageItems->statusId,
            'photo' => $storageItems->photo,
            'isDeleted' => $storageItems->isDeleted,
        ];
    }
}
