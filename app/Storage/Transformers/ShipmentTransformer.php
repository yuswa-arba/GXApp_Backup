<?php

namespace App\Storage\Transformers;

use App\Storage\Models\StorageShipments;
use App\Storage\Models\StorageSuppliers;
use App\Storage\Models\StorageWarehouses;
use App\Traits\GlobalUtils;
use League\Fractal\TransformerAbstract;

class ShipmentTransformer extends TransformerAbstract
{
    use GlobalUtils;

    public function transform(StorageShipments $storageShipments)
    {
        return [
            'id' => $storageShipments->id,
            'name' => $storageShipments->name,
            'website' => $storageShipments->website,
            'callCenter' => $storageShipments->callCenter,
            'editing' => false,
            'isDeleted'=>$storageShipments->isDeleted
        ];
    }
}
