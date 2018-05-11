<?php

namespace App\Storage\Transformers;

use App\Storage\Models\StorageSuppliers;
use App\Storage\Models\StorageWarehouses;
use App\Traits\GlobalUtils;
use League\Fractal\TransformerAbstract;

class SupplierTransformer extends TransformerAbstract
{
    use GlobalUtils;

    public function transform(StorageSuppliers $storageSuppliers)
    {
        return [
            'id'=>$storageSuppliers->id,
            'name'=>$storageSuppliers->name,
            'address'=>$storageSuppliers->address,
            'country'=>$storageSuppliers->country,
            'city'=>$storageSuppliers->city,
            'postalCode'=>$storageSuppliers->postalCode,
            'telephoneNumber'=>$storageSuppliers->telephoneNumber,
            'contactPerson1'=>$storageSuppliers->contactPerson1,
            'mobileNumber1'=>$storageSuppliers->mobileNumber1,
            'email1'=>$storageSuppliers->email1,
            'contactPerson2'=>$storageSuppliers->contactPerson2,
            'mobileNumber2'=>$storageSuppliers->mobileNumber2,
            'email2'=>$storageSuppliers->email2,
            'accountingNumber'=>$storageSuppliers->accountingNumber,
            'notes'=>$storageSuppliers->notes,
            'logo'=>$storageSuppliers->logo,
            'editing'=>false,
            'isDeleted'=>$storageSuppliers->isDeleted
        ];
    }
}
