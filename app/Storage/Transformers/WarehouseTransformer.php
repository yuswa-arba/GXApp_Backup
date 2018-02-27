<?php

namespace App\Storage\Transformers;

use App\Storage\Models\StorageWarehouses;
use App\Traits\GlobalUtils;
use League\Fractal\TransformerAbstract;

class WarehouseTransformer extends TransformerAbstract
{
    use GlobalUtils;

    public function transform(StorageWarehouses $storageWarehouses)
    {
        return [
            'id'=>$storageWarehouses->id,
            'name'=>$storageWarehouses->name,
            'address'=>$storageWarehouses->address,
            'country'=>$storageWarehouses->country,
            'city'=>$storageWarehouses->city,
            'postalCode'=>$storageWarehouses->postalCode,
            'phoneNumber'=>$storageWarehouses->phoneNumber,
        ];
    }
}
