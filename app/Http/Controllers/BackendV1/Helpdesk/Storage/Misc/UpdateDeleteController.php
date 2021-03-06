<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Storage\Misc;

use App\Components\Models\UnitOfMeasurements;
use App\Http\Controllers\BackendV1\Helpdesk\Traits\Configs;
use App\Http\Controllers\Controller;
use App\Storage\Models\StorageItemsCategory;
use App\Storage\Models\StorageItemTypes;
use App\Storage\Models\StorageSuppliers;
use App\Storage\Models\StorageWarehouses;
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
    //WAREHOUSE

    public function updateWarehouse(Request $request)
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

        $update = StorageWarehouses::where('id', $request->id)->update([
            'name' => ucwords($request->name),
            'address' => $request->address,
            'country' => $request->country,
            'city' => $request->city,
            'postalCode' => $request->postalCode,
            'phoneNumber' => $request->phoneNumber,
        ]);


        if ($update) {

            $response['isFailed'] = false;
            $response['message'] = 'Warehouse has been updated successfully';
            return response()->json($response, 200);

        } else {

            $response['isFailed'] = true;
            $response['message'] = 'Unable to update shipmnet';
            return response()->json($response, 200);

        }

    }

    public function deleteWarehouse(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(), ['id' => 'required']);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }

        //is valid

        $delete = StorageWarehouses::where('id', $request->id)->update(['isDeleted' => 1]);

        if ($delete) {

            $response['isFailed'] = false;
            $response['message'] = 'Success';
            return response()->json($response, 200);

        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to update warehouse';
            return response()->json($response, 200);
        }

    }

    public function undoDeleteWarehouse(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(), ['id' => 'required']);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }

        //is valid

        $delete = StorageWarehouses::where('id', $request->id)->update(['isDeleted' => 0]);

        if ($delete) {

            $response['isFailed'] = false;
            $response['message'] = 'Success';
            return response()->json($response, 200);

        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to update warehouse';
            return response()->json($response, 200);
        }

    }

    //UNITS

    public function updateUnit(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'formatValue' => 'required',
            'uomTypeId' => 'required'
        ]);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }

        //is valid

        $update = UnitOfMeasurements::where('id', $request->id)->update([
            'format' => $request->formatValue,
            'description' => $request->description,
            'unitOfMeasurementTypeId' => $request->uomTypeId,
        ]);


        if ($update) {

            $response['isFailed'] = false;
            $response['message'] = 'Unit has been updated successfully';
            return response()->json($response, 200);

        } else {

            $response['isFailed'] = true;
            $response['message'] = 'Unable to update unit';
            return response()->json($response, 200);

        }

    }

    public function deleteUnit(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(), ['id' => 'required']);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }

        //is valid

        $delete = UnitOfMeasurements::where('id', $request->id)->update(['isDeleted' => 1]);

        if ($delete) {

            $response['isFailed'] = false;
            $response['message'] = 'Success';
            return response()->json($response, 200);

        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to update unit';
            return response()->json($response, 200);
        }

    }

    public function undoDeleteUnit(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(), ['id' => 'required']);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }

        //is valid

        $delete = UnitOfMeasurements::where('id', $request->id)->update(['isDeleted' => 0]);

        if ($delete) {

            $response['isFailed'] = false;
            $response['message'] = 'Success';
            return response()->json($response, 200);

        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to update unit';
            return response()->json($response, 200);
        }

    }

    //SUPPLIER

    public function updateSupplier(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(), [
            'id' => 'required',
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

        $update = StorageSuppliers::where('id', $request->id)->update([
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
        ]);


        if ($update) {

            /*Handle logo uploads*/
            if ($request->hasFile('logo') && $request->file('logo')->isValid()) {

                /*Save new logo*/
                $filename = $this->getImageName($request->logo, $request->name);
                $request->logo->move(base_path(Configs::$IMAGE_PATH['SUPPLIERS_LOGO']), $filename);

                $supplier = StorageSuppliers::find($request->id);

                if ($supplier) {

                    /*Remove previous logo */
                    if ($supplier->logo) {
                        if (file_exists(base_path(Configs::$IMAGE_PATH['SUPPLIERS_LOGO']) . $supplier->logo)) {
                            unlink(base_path(Configs::$IMAGE_PATH['SUPPLIERS_LOGO']) . $supplier->logo);
                        }
                    }

                    /* Save new path */
                    $supplier->logo =$filename;
                    $supplier->save();

                }

            }

            $response['isFailed'] = false;
            $response['message'] = 'Supplier has been updated successfully';
            return response()->json($response, 200);

        } else {

            $response['isFailed'] = true;
            $response['message'] = 'Unable to update supplier';
            return response()->json($response, 200);

        }

    }

    public function deleteSupplier(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(), ['id' => 'required']);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }

        //is valid

        $delete = StorageSuppliers::where('id', $request->id)->update(['isDeleted' => 1]);

        if ($delete) {

            $response['isFailed'] = false;
            $response['message'] = 'Success';
            return response()->json($response, 200);

        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to update supplier';
            return response()->json($response, 200);
        }

    }

    public function undoDeleteSupplier(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(), ['id' => 'required']);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }

        //is valid

        $delete = StorageSuppliers::where('id', $request->id)->update(['isDeleted' => 0]);

        if ($delete) {

            $response['isFailed'] = false;
            $response['message'] = 'Success';
            return response()->json($response, 200);

        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to update supplier';
            return response()->json($response, 200);
        }

    }


}
