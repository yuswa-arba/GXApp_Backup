<?php

namespace App\Storage\Logics\Inventory;

use App\Http\Controllers\BackendV1\API\Traits\ConfigCodes;
use App\Storage\Models\StorageEntryInventoryHistory;
use App\Storage\Models\StorageGeneralInventory;
use App\Storage\Models\StorageInventoryItem;
use App\Storage\Models\StorageItems;
use App\Traits\GlobalUtils;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class InsertToInventoryLogic extends InsertUseCase
{
    use GlobalUtils;

    public function handle($request)
    {
        $response = array();

        if($request->items!=null){

            foreach ($request->items as $item) {

                //get item in storage item db
                $storageItem = StorageItems::find($item['itemId']);

                if ($storageItem) {

                    $inventoryItem = $this->createInventoryItem($item['itemId'], $request->branchOfficeId);


                    if ($inventoryItem) {

                        // Insert testing status ID
                        if ($storageItem->requiresTesting) {
                            $testingStatusId = ConfigCodes::$STORAGE_ITEM_TEST_STATUS['UNTESTED'];
                        } else {
                            $testingStatusId = ConfigCodes::$STORAGE_ITEM_TEST_STATUS['NO_NEED'];
                        }

                        // Check serial number validation
                        $serialNumber = $item['serialNumber'];
                        $isValid = true;
                        if ($storageItem->requiresSerialNumber && $serialNumber == '') {
                            $isValid = false;
                        }

                        if ($isValid) {

                            //insert to general inventory
                            $insertToGeneralInventory = StorageGeneralInventory::create([
                                'inventoryItemId' => $inventoryItem->id,
                                'quantity' => $item['quantity'],
                                'serialNumber' => $serialNumber,
                                'testStatusId' => $testingStatusId,
                                'latestUpdateAt' => Carbon::now()->format('d//m/Y H:i'),
                                'latestUpdateBy' => $this->getResultWithNullChecker1Connection(Auth::user(), 'employee', 'givenName')
                            ]);

                            if ($insertToGeneralInventory) {

                                //insert to inventory entry history
                                StorageEntryInventoryHistory::create([
                                    'storagePurchaseOrderId' => $request->storagePurchaseOrderId,
                                    'inventoryItemId'=>$inventoryItem->id,
                                    'itemId' => $item['itemId'],
                                    'serialNumber' => $item['serialNumber'],
                                    'quantity' => $item['quantity'],
                                    'branchOfficeId' => $request->branchOfficeId,
                                    'insertedBy' => $this->getResultWithNullChecker1Connection(Auth::user(), 'employee', 'givenName'),
                                    'insertedAt' => Carbon::now()->format('d//m/Y H:i')
                                ]);

                            }
                        }
                    }
                }

            }

            /* return response */
            $response['isFailed'] = false;
            $response['message'] = 'Items has been inserted successfully';
            return response()->json($response,200);
        } else {
            /* return response */
            $response['isFailed'] = true;
            $response['message'] = 'Items cannot be empty';
            return response()->json($response,200);
        }



    }

    private function createInventoryItem($itemId, $branchOfficeId)
    {
        Log::info('itemId:' . $itemId .' branchOfficeId:'. $branchOfficeId);

        return StorageInventoryItem::create(
            [
                'itemId' => $itemId,
                'branchOfficeId' => $branchOfficeId,
                'latestUpdateAt' => Carbon::now()->format('d/m/Y'),
                'latestUpdateBy' => $this->getResultWithNullChecker1Connection(Auth::user(), 'employee', 'givenName')
            ]
        );
    }
}