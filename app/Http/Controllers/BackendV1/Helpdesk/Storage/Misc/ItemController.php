<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Storage\Misc;

use App\Components\Models\UnitOfMeasurements;
use App\Components\Transformers\UnitOfMeasurementTransformer;
use App\Http\Controllers\BackendV1\Helpdesk\Traits\Configs;
use App\Http\Controllers\Controller;
use App\Storage\Logics\Item\CreateItemLogic;
use App\Storage\Logics\Item\GetItemListLogic;
use App\Storage\Models\StorageItems;
use App\Storage\Models\StorageItemsCategory;
use App\Storage\Models\StorageItemTypes;
use App\Storage\Models\StorageShipments;
use App\Storage\Models\StorageSuppliers;
use App\Storage\Models\StorageWarehouses;
use App\Storage\Transformers\BasicCodeNameTransformer;
use App\Storage\Transformers\ShipmentTransformer;
use App\Storage\Transformers\StorageItemDetailTransformer;
use App\Storage\Transformers\SupplierTransformer;
use App\Storage\Transformers\WarehouseTransformer;
use App\Traits\GlobalUtils;
use Illuminate\Http\Request;
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
//            'itemCode'=>'required|unique:storageItems', //unique
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




}
