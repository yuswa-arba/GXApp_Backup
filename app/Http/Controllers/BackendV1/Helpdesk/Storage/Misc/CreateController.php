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

class CreateController extends Controller
{

    use GlobalUtils;

    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function createItemCategory(Request $request)
    {
        $response = array();
        $validator = Validator::make($request->all(), ['code' => 'required', 'name' => 'required']);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }

        //is valid

        $create = StorageItemsCategory::create(['code' => strtoupper($request->code), 'name' => ucwords($request->name),'isDeleted'=>0]);

        if ($create) {

            $response['isFailed'] = false;
            $response['message'] = 'Success';
            $response['itemCategory'] = fractal($create, new BasicCodeNameTransformer());
            return response()->json($response, 200);

        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to create item category';
            return response()->json($response, 200);
        }

    }

    public function createItemType(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(), ['code' => 'required', 'name' => 'required']);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }

        //is valid

        $create = StorageItemTypes::create(['code' => strtoupper($request->code), 'name' => ucwords($request->name),'isDeleted'=>0]);

        if ($create) {

            $response['isFailed'] = false;
            $response['message'] = 'Success';
            $response['itemType'] = fractal($create, new BasicCodeNameTransformer());

            return response()->json($response, 200);

        } else {

            $response['isFailed'] = true;
            $response['message'] = 'Unable to create item category';

            return response()->json($response, 200);
        }

    }

    public function createShipment(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(), ['name' => 'required']);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }

        //is valid

        $create = StorageShipments::create([
            'name' => $request->name,
            'website' => $request->website,
            'callCenter' => $request->callCenter,
            'isDeleted'=>0
        ]);

        if ($create) {
            $response['isFailed'] = false;
            $response['message'] = 'Success';
            $response['shipment'] = fractal($create, new ShipmentTransformer());
            return response()->json($response, 200);

        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to create item category';
            return response()->json($response, 200);
        }
    }

    public function createSupplier(Request $request)
    {

        $response = array();

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'country' => 'required',
            'city' => 'required',
            'postalCode' => 'required',
            'telephoneNumber' => 'required',
        ]);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }

        //is valid

        $filename = '';

        /*Handle logo uploads*/
        if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
            /*Save new logo*/
            $filename = $this->getImageName($request->logo, $request->name);
            $request->logo->move(base_path(Configs::$IMAGE_PATH['SUPPLIERS_LOGO']), $filename);
        }

        $create = StorageSuppliers::create([
            'name' => $request->name,
            'address' => $request->address,
            'country' => $request->country,
            'city' => $request->city,
            'postalCode' => $request->postalCode,
            'telephoneNumber' => $request->telephoneNumber,
            'contactPerson1' => $request->contactPerson1,
            'mobileNumber1' => $request->mobileNumber1,
            'email1' => $request->email1,
            'contactPerson2' => $request->contactPerson2,
            'mobileNumber2' => $request->mobileNumber2,
            'email2' => $request->email2,
            'accountingNumber' => $request->accountingNumber,
            'notes' => $request->notes,
            'logo' => $filename,
            'isDeleted'=>0
        ]);

        if ($create) {
            $response['isFailed'] = false;
            $response['message'] = 'Success';
            $response['supplier'] = fractal($create, new SupplierTransformer());
            return response()->json($response, 200);

        } else {

            /* Remove photo */
            if(file_exists(base_path(Configs::$IMAGE_PATH['SUPPLIERS_LOGO']).$filename)){
                unlink(base_path(Configs::$IMAGE_PATH['SUPPLIERS_LOGO']).$filename);
            }

            $response['isFailed'] = true;
            $response['message'] = 'Unable to create item category';
            return response()->json($response, 200);
        }


    }

    public function createWarehouse(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'country' => 'required',
            'city' => 'required',
            'postalCode' => 'required',
            'phoneNumber' => 'required',
        ]);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }

        //is valid

        $create = StorageWarehouses::create([
            'name' => $request->name,
            'address' => $request->address,
            'country' => $request->country,
            'city' => $request->city,
            'postalCode' => $request->postalCode,
            'phoneNumber' => $request->phoneNumber,
            'isDeleted'=>0
        ]);

        if ($create) {
            $response['isFailed'] = false;
            $response['message'] = 'Success';
            $response['warehouse'] = fractal($create, new WarehouseTransformer());
            return response()->json($response, 200);

        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to create item category';
            return response()->json($response, 200);
        }

    }

    public function createUnit(Request $request)
    {

        $response = array();

        $validator = Validator::make($request->all(), [
            'formatValue' => 'required',
            'description' => 'required',
            'uomTypeId' => 'required'
        ]);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }

        //is valid

        $create = UnitOfMeasurements::create([
            'format' => $request->formatValue, // use formatValue because 'format' has protected access
            'description' => $request->description,
            'unitOfMeasurementTypeId' => $request->uomTypeId,
            'isDeleted'=>0
        ]);

        if ($create) {

            $response['isFailed'] = false;
            $response['message'] = 'Success';
            $response['unit'] = fractal($create, new UnitOfMeasurementTransformer());
            return response()->json($response, 200);

        } else {

            $response['isFailed'] = true;
            $response['message'] = 'Unable to create item category';
            return response()->json($response, 200);

        }

    }

}
