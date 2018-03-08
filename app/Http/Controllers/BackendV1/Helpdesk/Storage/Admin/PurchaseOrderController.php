<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Storage\Admin;

use App\Components\Models\UnitOfMeasurements;
use App\Components\Transformers\UnitOfMeasurementTransformer;
use App\Http\Controllers\BackendV1\API\Traits\ConfigCodes;
use App\Http\Controllers\BackendV1\Helpdesk\Traits\Configs;
use App\Http\Controllers\Controller;
use App\Storage\Logics\Item\CreateItemLogic;
use App\Storage\Logics\Item\GetItemListLogic;
use App\Storage\Logics\Requisition\GetShopItemDetailLogic;
use App\Storage\Logics\Requisition\GetShopItemListLogic;
use App\Storage\Models\StorageItems;
use App\Storage\Models\StorageItemsCategory;
use App\Storage\Models\StorageItemTypes;
use App\Storage\Models\StorageRequestCart;
use App\Storage\Models\StorageRequisition;
use App\Storage\Models\StorageRequisitionItems;
use App\Storage\Models\StorageShipments;
use App\Storage\Models\StorageSuppliers;
use App\Storage\Models\StorageWarehouses;
use App\Storage\Transformers\BasicCodeNameTransformer;
use App\Storage\Transformers\BriefStorageRequisitionListTransformer;
use App\Storage\Transformers\BriefSupplierTransformer;
use App\Storage\Transformers\ShipmentTransformer;
use App\Storage\Transformers\StorageItemBriefDetailTransformer;
use App\Storage\Transformers\StorageItemDetailTransformer;
use App\Storage\Transformers\StorageItemInsideCartDetailTransformer;
use App\Storage\Transformers\StorageRequisitionListTransformer;
use App\Storage\Transformers\SupplierTransformer;
use App\Storage\Transformers\WarehouseTransformer;
use App\Traits\GlobalUtils;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PurchaseOrderController extends Controller
{

    use GlobalUtils;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('auth.admin');
    }

    public function availableRequisition(Request $request)
    {
        $response = array();
        // is valid

        $user = Auth::user(); //user data
        $employee = $user->employee; // user's employee data

        $approvalId = ConfigCodes::$REQUISITION_APPROVAL_STATUS['APPROVED']; //default approval id

        if ($employee && $employee->hasResigned != 1) {

            $requisitions = StorageRequisition::where('approvalId', $approvalId)
                ->whereNotNull('approvalNumber')
                ->orderBy('id', 'desc')
                ->limit(50)//get 50 rows
                ->get();

            if ($requisitions) {

                $response['isFailed'] = false;
                $response['message'] = 'Success';
                $response['requisitions'] = fractal($requisitions, new BriefStorageRequisitionListTransformer());

                return response()->json($response, 200);

            } else {
                $response['isFailed'] = true;
                $response['message'] = 'Unable to find requisition';
                return response()->json($response, 200);
            }


        } else {
            /* Return error response */
            $response['isFailed'] = true;
            $response['message'] = 'Permission denied';
            return response()->json($response, 200);
        }
    }

    public function searchAvailableRequisition(Request $request)
    {

        $response = array();
        // is valid

        $user = Auth::user(); //user data
        $employee = $user->employee; // user's employee data

        $search = '';
        if ($request->v != '' && $request->v != null) {
            $search = $request->v;
        }

        $approvalId = ConfigCodes::$REQUISITION_APPROVAL_STATUS['APPROVED']; //default approval id

        if ($employee && $employee->hasResigned != 1) {

            $requisitions = StorageRequisition::where('approvalId', $approvalId)
                ->whereNotNull('approvalNumber')
                ->where(function ($query) use ($search) {
                    $query->where('approvalNumber', 'like', '%' . $search . '%');
                })
                ->orderBy('id', 'desc')
                ->limit(50)//get 50 rows
                ->get();

            if ($requisitions) {

                $response['isFailed'] = false;
                $response['message'] = 'Success';
                $response['requisitions'] = fractal($requisitions, new BriefStorageRequisitionListTransformer());

                return response()->json($response, 200);

            } else {
                $response['isFailed'] = true;
                $response['message'] = 'Unable to find requisition';
                return response()->json($response, 200);
            }


        } else {
            /* Return error response */
            $response['isFailed'] = true;
            $response['message'] = 'Permission denied';
            return response()->json($response, 200);
        }
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

    public function searchSupplier(Request $request)
    {
        $response = array();

        $search = '';
        if ($request->get('v') != '' && $request->get('v') != null) {
            $search = $request->get('v');
        }

        $suppliers = StorageSuppliers::where('isDeleted', 0)
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('contactPerson1', 'like', '%' . $search . '%');
            })
            ->orderBy('name', 'asc')
            ->get();

        $response['isFailed'] = false;
        $response['message'] = 'Success';
        $response['suppliers'] = fractal($suppliers, new BriefSupplierTransformer());

        return response()->json($response, 200);
    }

    public function searchItem(Request $request)
    {
        $search = $request->v;

        if ($search != '') {

            $items = StorageItems::where('isDeleted', 0)// where its not deleted
            ->where(function ($query) use ($search) {
                $query->where('itemCode', 'like', '%' . $search . '%')// where matches item code
                ->orWhere('name', 'like', '%' . $search . '%'); // or matches item name
            })
                ->get();
        } else {

            $items = StorageItems::where('isDeleted', 0)// where its not deleted
            ->get();
        }

        if ($items) {

            $response['isFailed'] = false;
            $response['message'] = 'Success';
            $response['items'] = fractal($items, new StorageItemBriefDetailTransformer());

            return response()->json($response, 200);

        } else {

            $response['isFailed'] = true;
            $response['message'] = 'Items not found';

            return response()->json($response, 200);

        }


    }

}