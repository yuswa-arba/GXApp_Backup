<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Storage\Misc;

use App\Components\Models\UnitOfMeasurements;
use App\Components\Transformers\BasicComponentTrasnformer;
use App\Components\Transformers\UnitOfMeasurementTransformer;
use App\Http\Controllers\Controller;
use App\Storage\Models\StorageItemsCategory;
use App\Storage\Models\StorageItemStatus;
use App\Storage\Models\StorageItemTypes;
use App\Storage\Models\StorageRequisitionApproval;
use App\Storage\Models\StorageShipments;
use App\Storage\Models\StorageSuppliers;
use App\Storage\Models\StorageWarehouses;
use App\Storage\Transformers\BasicCodeNameTransformer;
use App\Storage\Transformers\BriefSupplierTransformer;
use App\Storage\Transformers\ShipmentTransformer;
use App\Storage\Transformers\SupplierTransformer;
use App\Storage\Transformers\WarehouseTransformer;
use DeepCopy\f001\B;
use Illuminate\Http\Request;

class ListController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function itemList()
    {
        $response = array();
    }

    public function itemCategoryList()
    {
        $response = array();

        $categories = StorageItemsCategory::orderBy('code', 'asc')->get();

        $response['isFailed'] = false;
        $response['message'] = 'Success';
        $response['categories'] = fractal($categories, new BasicCodeNameTransformer());

        return response()->json($response, 200);

    }

    public function itemTypeList()
    {
        $response = array();

        $itemTypes = StorageItemTypes::orderBy('code', 'asc')->get();

        $response['isFailed'] = false;
        $response['message'] = 'Success';
        $response['types'] = fractal($itemTypes, new BasicCodeNameTransformer());

        return response()->json($response, 200);
    }

    public function shipmentList()
    {
        $response = array();

        $shipments = StorageShipments::orderBy('name', 'asc')->get();

        $response['isFailed'] = false;
        $response['message'] = 'Success';
        $response['shipments'] = fractal($shipments, new ShipmentTransformer());

        return response()->json($response, 200);
    }

    public function statusList()
    {
        $response = array();

        $status = StorageItemStatus::orderBy('name', 'asc')->get();

        $response['isFailed'] = false;
        $response['message'] = 'Success';
        $response['status'] = fractal($status, new BasicComponentTrasnformer());

        return response()->json($response, 200);
    }


    public function supplierList()
    {
        $response = array();

        $suppliers = StorageSuppliers::orderBy('name', 'asc')->get();

        $response['isFailed'] = false;
        $response['message'] = 'Success';
        $response['suppliers'] = fractal($suppliers, new SupplierTransformer());

        return response()->json($response, 200);
    }

    public function warehouseList()
    {
        $response = array();

        $warehouses = StorageWarehouses::orderBy('name', 'asc')->get();

        $response['isFailed'] = false;
        $response['message'] = 'Success';
        $response['warehouses'] = fractal($warehouses, new WarehouseTransformer());

        return response()->json($response, 200);
    }

    public function unitList()
    {
        $response = array();

        $units = UnitOfMeasurements::all();

        $response['isFailed'] = false;
        $response['message'] = 'Success';
        $response['units'] = fractal($units, new UnitOfMeasurementTransformer());

        return response()->json($response, 200);

    }

    public function approvaStatuslList()
    {
        $response = array();

        $approvalStatuses = StorageRequisitionApproval::all();
        $response['isFailed'] = false;
        $response['message'] = 'Success';
        $response['approvalStatuses'] = fractal($approvalStatuses, new BasicComponentTrasnformer());

        return response()->json($response, 200);

    }

}
