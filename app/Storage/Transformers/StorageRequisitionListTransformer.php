<?php

namespace App\Storage\Transformers;

use App\Storage\Models\StorageItems;
use App\Storage\Models\StorageRequisition;
use App\Storage\Models\StorageWarehouses;
use App\Traits\GlobalUtils;
use Illuminate\Support\Facades\Log;
use League\Fractal\TransformerAbstract;

class StorageRequisitionListTransformer extends TransformerAbstract
{
    use GlobalUtils;

    protected $defaultIncludes = [
        'requisitionItems',
        'deliveryWarehouse'
    ];

    public function transform(StorageRequisition $storageRequisition)
    {
        return [
            'id' => $storageRequisition->id,
            'requisitionNumber' => $storageRequisition->requisitionNumber,
            'approvalNumber' => $storageRequisition->approvalNumber,
            'requestedAt' => $storageRequisition->requestedAt,
            'requestedBy' => $storageRequisition->requestedBy,
            'requesterEmployeeName' => $this->getResultWithNullChecker1Connection($storageRequisition,'requesterEmployee','givenName'),
            'divisionName'=>$this->getResultWithNullChecker1Connection($storageRequisition,'division','name'),
            'dateNeededBy'=>$storageRequisition->dateNeededBy,
            'description' => $storageRequisition->description,
            'approvalId'=>$storageRequisition->approvalId,
            'approvalName'=>$this->getResultWithNullChecker1Connection($storageRequisition,'approval','name')
        ];
    }

    public function includeRequisitionItems(StorageRequisition $storageRequisition)
    {
        $items = $storageRequisition->requisitionItems;
        return $this->collection($items, new StorageRequisitionItemTransformer,'items');
    }

    public function includeDeliveryWarehouse(StorageRequisition $storageRequisition)
    {
        $warehouse = StorageWarehouses::where('id',$storageRequisition->deliveryWarehouseId)->get();
        return $this->collection($warehouse,new WarehouseTransformer,'warehouse');
    }
}
