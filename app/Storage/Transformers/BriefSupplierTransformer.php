<?php

namespace App\Storage\Transformers;

use App\Storage\Models\StorageSuppliers;
use App\Storage\Models\StorageWarehouses;
use App\Traits\GlobalUtils;
use League\Fractal\TransformerAbstract;

class BriefSupplierTransformer extends TransformerAbstract
{
    use GlobalUtils;

    public function transform(StorageSuppliers $storageSuppliers)
    {
        return [
            'id'=>$storageSuppliers->id,
            'name'=>$storageSuppliers->name,
            'country'=>$storageSuppliers->country,
            'city'=>$storageSuppliers->city,
            'contactPerson1'=>$storageSuppliers->contactPerson1,
            'mobileNumber1'=>$storageSuppliers->mobileNumber1,
            'logo'=>$storageSuppliers->logo,
            'editing'=>false,
            'isDeleted'=>$storageSuppliers->isDeleted
        ];
    }
}
