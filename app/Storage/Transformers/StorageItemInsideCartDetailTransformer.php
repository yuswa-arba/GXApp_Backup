<?php

namespace App\Storage\Transformers;

use App\Storage\Models\StorageItems;
use App\Storage\Models\StorageRequestCart;
use App\Storage\Models\StorageWarehouses;
use App\Traits\GlobalUtils;
use League\Fractal\TransformerAbstract;

class StorageItemInsideCartDetailTransformer extends TransformerAbstract
{
    use GlobalUtils;

    public function transform(StorageRequestCart $storageItemsCart)
    {
        return [
            'id' => $storageItemsCart->id,
            'employeeName'=>$this->getResultWithNullChecker1Connection($storageItemsCart,'employee','givenName'),
            'itemCode' => $this->getResultWithNullChecker1Connection($storageItemsCart, 'item', 'itemCode'),
            'itemName' => $this->getResultWithNullChecker1Connection($storageItemsCart, 'item', 'name'),
            'itemPhoto'=>$this->getResultWithNullChecker1Connection($storageItemsCart,'item','photo'),
            'itemUnit'=>$this->getResultWithNullChecker2Connection($storageItemsCart,'item','unitOfMeasurement','format'),
            'amount' => $storageItemsCart->amount,
            'notes' => $storageItemsCart->notes,
            'insertedAt' => $storageItemsCart->insertedAt
        ];
    }
}
