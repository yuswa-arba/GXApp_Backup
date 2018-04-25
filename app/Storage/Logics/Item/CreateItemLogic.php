<?php

namespace App\Storage\Logics\Item;

use App\Employee\Models\MasterEmployee;
use App\Employee\Transformers\EmployeeListTransfomer;
use App\Http\Controllers\BackendV1\Helpdesk\Traits\Configs;
use App\Storage\Models\StorageItems;
use App\Storage\Transformers\StorageItemDetailTransformer;
use App\Traits\GlobalUtils;

class CreateItemLogic extends CreateUseCase
{

    use GlobalUtils;


    public function handleCreate($request)
    {
        // Get total item of  a category category
        $currentTotalItemOfCategory = StorageItems::where('categoryCode', $request->categoryCode)->count();

        // Get Item Number
        $itemNumber = $this->zeroPrefix($currentTotalItemOfCategory + 1, 3);

        // Add prefix on Accounting Number
        $accNumber = $this->zeroPrefix(str_replace('0','',$request->accountingNumber), 5);

        // Get Item Code e.g. CAA-001234-0005
        $itemCode = $request->itemTypeCode . $request->categoryCode . '-' . $accNumber . '-' . $itemNumber;

        //Handle photo upload
        $filename = '';

        /*Handle logo uploads*/
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            /*Save new logo*/
            $filename = $this->getImageName($request->photo, str_replace('-','',$request->itemCode));
            $request->photo->move(base_path(Configs::$IMAGE_PATH['STORAGE_ITEM']), $filename);
        }

        // Save Item to DB
        $create = StorageItems::create([
            'itemCode'=>$itemCode,
            'name' => ucwords($request->name),
            'unitId' => $request->unitId,
            'itemTypeCode' => $request->itemTypeCode,
            'categoryCode' => $request->categoryCode,
            'accountingNumber' => $request->accountingNumber,
            'itemNumber'=>$itemNumber,
            'reminder1' => $request->reminder1,
            'reminder2' => $request->reminder2,
            'minimumStock' => $request->minimumStock,
            'allowNotification' => $request->allowNotification,
            'statusId' => $request->statusId,
            'photo'=>$filename,
            'requiresTesting'=>$request->requiresTesting?1:0,
            'requiresSerialNumber'=>$request->requiresSerialNumber?1:0,
            'isDeleted'=>0
        ]);

        // Return response
        if($create){

            $response['isFailed'] = false;
            $response['message'] = 'Item has been created successfully';
            $response['item']= fractal($create,new StorageItemDetailTransformer());
            return response()->json($response,200);

        } else {

            /* Remove photo */
            if(file_exists(base_path(Configs::$IMAGE_PATH['STORAGE_ITEM']).$filename)){
                unlink(base_path(Configs::$IMAGE_PATH['STORAGE_ITEM']).$filename);
            }

            $response['isFailed'] = true;
            $response['message'] = 'Unable to create storage item';
            return response()->json($response,200);

        }

    }
}