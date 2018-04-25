<?php

namespace App\Storage\Transformers;

use App\Storage\Models\StorageGeneralInventory;
use App\Traits\GlobalUtils;
use League\Fractal\TransformerAbstract;

class StorageGeneralInventoryListTransformer extends TransformerAbstract
{
    use GlobalUtils;

    public function transform(StorageGeneralInventory $generalInventory)
    {
        return [
            'id' => $generalInventory->id,
            'inventoryItemId' => $generalInventory->inventoryItemId,
            'itemId' => $this->getResultWithNullChecker1Connection($generalInventory, 'inventoryItem', 'itemId'),
            'itemName' => $this->getResultWithNullChecker2Connection($generalInventory, 'inventoryItem', 'item', 'name'),
            'itemCode' => $this->getResultWithNullChecker2Connection($generalInventory, 'inventoryItem', 'item', 'itemCode'),
            'itemCategory' => $this->getResultWithNullChecker3Connection($generalInventory, 'inventoryItem', 'item', 'itemCategory', 'name'),
            'unitFormat' => $this->getResultWithNullChecker3Connection($generalInventory, 'inventoryItem', 'item', 'unitOfMeasurement', 'format'),
            'minStock' => $this->getResultWithNullChecker2Connection($generalInventory, 'inventoryItem', 'item', 'minimumStock'),
            'quantity' => $generalInventory->quantity,
            'serialNumber' => $generalInventory->serialNumber,
            'testStatusId' => $generalInventory->testStatusId,
            'latestUpdateAt' => $generalInventory->latestUpdateAt,
            'latestUpdateBy' => $generalInventory->latestUpdateBy,
            'priceSale' => $this->getResultWithNullChecker2Connection($generalInventory, 'inventoryItem', 'item', 'latestSellingPrice'),
        ];
    }
}
