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
           'id'=>$storageShipments->id,
           'name'=>$storageShipments->name,
           'shippingTypeName'=>$this->getResultWithNullChecker1Connection($storageShipments,'shippingType','name'),
           'website'=>$storageShipments->website,
           'callCenter'=>$storageShipments->callCenter,
        ];
    }
}
