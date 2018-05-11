<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Storage\Misc;

use App\Http\Controllers\Controller;
use App\Storage\Logics\Item\CreateItemLogic;
use App\Storage\Logics\Item\GetItemListLogic;
use App\Storage\Models\StorageItems;
use App\Traits\GlobalUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{

    use GlobalUtils;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function itemList(Request $request)
    {
        return GetItemListLogic::getData($request);
    }

    public function createItem(Request $request)
    {

        $response = array();

        $validator = Validator::make($request->all(), [
            //'itemCode'=>'required|unique:storageItems', //unique
            'name' => 'required',
            'unitId' => 'required',
            'itemTypeCode' => 'required',
            'categoryCode' => 'required',
            'accountingNumber' => 'required',
        ]);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }

        //is valid

        return CreateItemLogic::create($request);

    }

    public function deleteItem(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(), ['id' => 'required']);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }

        //is valid

        $delete = StorageItems::where('id', $request->id)->update(['isDeleted' => 1]);

        if ($delete) {

            $response['isFailed'] = false;
            $response['message'] = 'Success';
            return response()->json($response, 200);

        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to update item';
            return response()->json($response, 200);
        }

    }

    public function undoDeleteItem(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(), ['id' => 'required']);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }

        //is valid

        $undoDelete = StorageItems::where('id', $request->id)->update(['isDeleted' => 0]);

        if ($undoDelete) {

            $response['isFailed'] = false;
            $response['message'] = 'Success';

            return response()->json($response, 200);

        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to update item';

            return response()->json($response, 200);
        }

    }

    public function updateItemStatus(Request $request)
    {
        $response = array();

        $validator =Validator::make($request->all(),[
            'id'=>'required',
            'statusId'=>'required'
        ]);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }

        //is valid

        $updateStatus = StorageItems::where('id',$request->id)->update(['statusId'=>$request->statusId]);

        if ($updateStatus) {

            $response['isFailed'] = false;
            $response['message'] = 'Success';

            return response()->json($response, 200);

        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to update item';

            return response()->json($response, 200);
        }



    }

    public function editItemPrice(Request $request)
    {

        $response = array();

        $validator = Validator::make($request->all(), ['id' => 'required']);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }

        //is valid

        $item = StorageItems::find($request->id);

        if ($item) {

            $item->finePrice = $request->finePrice;
            $item->latestSellingPrice = $request->sellingPrice;
            $item->latestPurchasedPrice = $request->purchasedPrice;

            if ($item->save()) {

                $response['isFailed'] = false;
                $response['message'] = 'Success';
                return response()->json($response, 200);

            } else {
                $response['isFailed'] = true;
                $response['message'] = 'Unable to save item';
                return response()->json($response, 200);
            }

        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to find item';
            return response()->json($response, 200);
        }


    }


}
