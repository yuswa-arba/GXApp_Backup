<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Storage\Misc;

use App\Components\Models\UnitOfMeasurements;
use App\Components\Transformers\UnitOfMeasurementTransformer;
use App\Http\Controllers\BackendV1\Helpdesk\Traits\Configs;
use App\Http\Controllers\Controller;
use App\Storage\Models\StorageItemsCategory;
use App\Storage\Models\StorageItemTypes;
use App\Storage\Models\StorageShipments;
use App\Storage\Models\StorageSuppliers;
use App\Storage\Models\StorageWarehouses;
use App\Storage\Transformers\BasicCodeNameTransformer;
use App\Storage\Transformers\ShipmentTransformer;
use App\Storage\Transformers\SupplierTransformer;
use App\Storage\Transformers\WarehouseTransformer;
use App\Traits\GlobalUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UpdateDeleteController extends Controller
{

    use GlobalUtils;

    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function updateItemCategory(Request $request)
    {
        $response = array();
        $validator = Validator::make($request->all(), ['code' => 'required', 'name' => 'required']);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }

        //is valid

        $update = StorageItemsCategory::where('code', strtoupper($request->code))->update(['name' => ucwords($request->name)]);

        if ($update) {

            $response['isFailed'] = false;
            $response['message'] = 'Success';
            return response()->json($response, 200);

        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to update item category';
            return response()->json($response, 200);
        }
    }

    public function deleteItemCategory(Request $request)
    {
        $response = array();
        $validator = Validator::make($request->all(), ['code' => 'required']);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }

        //is valid

        $delete = StorageItemsCategory::where('code', strtoupper($request->code))->update(['isDeleted' => 1]);

        if ($delete) {

            $response['isFailed'] = false;
            $response['message'] = 'Success';
            return response()->json($response, 200);

        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to update item category';
            return response()->json($response, 200);
        }
    }

    public function undoDeleteItemCategory(Request $request)
    {
        $response = array();
        $validator = Validator::make($request->all(), ['code' => 'required']);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }

        //is valid

        $delete = StorageItemsCategory::where('code', strtoupper($request->code))->update(['isDeleted' => 0]);

        if ($delete) {

            $response['isFailed'] = false;
            $response['message'] = 'Success';
            return response()->json($response, 200);

        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to update item category';
            return response()->json($response, 200);
        }
    }


    public function updateItemType(Request $request)
    {
        $response = array();
        $validator = Validator::make($request->all(), ['code' => 'required', 'name' => 'required']);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }

        //is valid

        $update = StorageItemTypes::where('code', strtoupper($request->code))->update(['name' => ucwords($request->name)]);

        if ($update) {

            $response['isFailed'] = false;
            $response['message'] = 'Success';
            return response()->json($response, 200);

        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to update item type';
            return response()->json($response, 200);
        }
    }

    public function deleteItemType(Request $request)
    {
        $response = array();
        $validator = Validator::make($request->all(), ['code' => 'required']);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }

        //is valid

        $delete = StorageItemTypes::where('code', strtoupper($request->code))->update(['isDeleted' => 1]);

        if ($delete) {

            $response['isFailed'] = false;
            $response['message'] = 'Success';
            return response()->json($response, 200);

        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to update item type';
            return response()->json($response, 200);
        }
    }

    public function undoDeleteItemType(Request $request)
    {
        $response = array();
        $validator = Validator::make($request->all(), ['code' => 'required']);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }

        //is valid

        $delete = StorageItemTypes::where('code', strtoupper($request->code))->update(['isDeleted' => 0]);

        if ($delete) {

            $response['isFailed'] = false;
            $response['message'] = 'Success';
            return response()->json($response, 200);

        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to update item type';
            return response()->json($response, 200);
        }
    }

    public function updateShipment(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }

        //is valid

        $update = StorageShipments::where('id', $request->id)->update([
            'name' => ucwords($request->name),
            'website' => $request->website,
            'callCenter' => $request->callCenter
        ]);


        if ($update) {

            $response['isFailed'] = false;
            $response['message'] = 'Shipment has been updated successfully';
            return response()->json($response, 200);

        } else {

            $response['isFailed'] = true;
            $response['message'] = 'Unable to update shipmnet';
            return response()->json($response, 200);

        }

    }

    public function deleteShipment(Request $request)
    {
        $response =array();

        $validator = Validator::make($request->all(),['id'=>'required']);

        if($validator->fails()){
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response,200);
        }

        //is valid

        $delete = StorageShipments::where('id', $request->id)->update(['isDeleted'=>1]);

        if ($delete) {

            $response['isFailed'] = false;
            $response['message'] = 'Success';
            return response()->json($response, 200);

        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to update shipment';
            return response()->json($response, 200);
        }

    }

    public function undoDeleteShipment(Request $request)
    {
        $response =array();

        $validator = Validator::make($request->all(),['id'=>'required']);

        if($validator->fails()){
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response,200);
        }

        //is valid

        $delete = StorageShipments::where('id', $request->id)->update(['isDeleted'=>0]);

        if ($delete) {

            $response['isFailed'] = false;
            $response['message'] = 'Success';
            return response()->json($response, 200);

        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to update shipment';
            return response()->json($response, 200);
        }

    }
}
