<?php

namespace App\Storage\Transformers;

use App\Storage\Models\StorageItems;
use App\Storage\Models\StorageRequisition;
use App\Storage\Models\StorageWarehouses;
use App\Traits\GlobalUtils;
use Illuminate\Support\Facades\Log;
use League\Fractal\TransformerAbstract;

class BriefStorageRequisitionListTransformer extends TransformerAbstract
{
    use GlobalUtils;

    public function transform(StorageRequisition $storageRequisition)
    {
        return [
            'id' => $storageRequisition->id,
            'requisitionNumber' => $storageRequisition->requisitionNumber,
            'approvalNumber' => $storageRequisition->approvalNumber,
            'requestedAt' => $storageRequisition->requestedAt,
            'requestedBy' => $storageRequisition->requestedBy,
            'divisionName'=>$this->getResultWithNullChecker1Connection($storageRequisition,'division','name'),
            'dateNeededBy'=>$storageRequisition->dateNeededBy,
            'description' => $storageRequisition->description,
        ];
    }
}
