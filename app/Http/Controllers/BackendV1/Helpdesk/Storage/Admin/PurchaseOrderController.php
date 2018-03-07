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
                ->where(function($query)use($search){
                    $query->where('approvalNumber','like','%'.$search.'%');
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

}