<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Storage\Admin;

use App\Http\Controllers\BackendV1\API\Traits\ConfigCodes;
use App\Http\Controllers\BackendV1\API\Traits\ResponseCodes;
use App\Http\Controllers\Controller;
use App\Storage\Jobs\NotifyRequestTracking;
use App\Storage\Logics\PurchaseOrder\CreatePurchaseOrderLogic;
use App\Storage\Models\StorageItems;
use App\Storage\Models\StoragePurchaseOrderItems;
use App\Storage\Models\StoragePurchaseOrderItemTrack;
use App\Storage\Models\StoragePurchaseOrders;
use App\Storage\Models\StorageRequisition;
use App\Storage\Models\StorageRequisitionItems;
use App\Storage\Models\StorageSuppliers;
use App\Storage\Models\StorageWarehouses;
use App\Storage\Transformers\BriefStorageRequisitionListTransformer;
use App\Storage\Transformers\BriefSupplierTransformer;
use App\Storage\Transformers\StorageItemBriefDetailTransformer;
use App\Storage\Transformers\StoragePurchaseOrderTransformer;
use App\Storage\Transformers\StorageRequisitionItemTransformer;
use App\Storage\Transformers\StorageRequisitionListTransformer;
use App\Storage\Transformers\SupplierTransformer;
use App\Storage\Transformers\WarehouseTransformer;
use App\Traits\GlobalConfig;
use App\Traits\GlobalUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade as PDF;

class PurchaseOrderController extends Controller
{

    use GlobalUtils;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('auth.admin');
    }

    public function createPurchaseOrder(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(), [
            'POForm' => 'required',
            'POItems' => 'required'
        ]);

        if ($validator->fails()) {

            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);

        }

        // is valid
        $user = Auth::user(); //user data
        $employee = $user->employee; // user's employee data


        if ($employee && $employee->hasResigned != 1) {

            return CreatePurchaseOrderLogic::create($request);

        } else {
            /* Return error response */
            $response['isFailed'] = true;
            $response['message'] = 'Permission denied';
            return response()->json($response, 200);
        }

    }

    public function purchaseOrderList(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(), [

        ]);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }

        // is valid
        $user = Auth::user(); //user data
        $employee = $user->employee; // user's employee data


        if ($employee && $employee->hasResigned != 1) {

            $statusId = '';

            if ($request->sortStatus != '' && $request->sortStatus != null) {
                $statusId = $request->sortStatus;
            }

            $purchaseOrders = StoragePurchaseOrders::orderBy('id', 'desc')->paginate(30); // default get all

            if ($statusId != '') { // sort by status

                $purchaseOrders = StoragePurchaseOrders::where('statusId', $statusId)->orderBy('id', 'desc')->paginate(30);
            }

            if ($purchaseOrders) {

                $response['isFailed'] = false;
                $response['message'] = 'Success';
                $response['purchaseOrders'] = fractal($purchaseOrders, new StoragePurchaseOrderTransformer());

                return response()->json($response, 200);

            } else {

                $response['isFailed'] = true;
                $response['message'] = 'No purchase order found';
                return response()->json($response, 200);

            }

        } else {
            /* Return error response */
            $response['isFailed'] = true;
            $response['message'] = 'Permission denied';
            return response()->json($response, 200);
        }

    }

    public function purchaseOrderDetail(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {

            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';

            return response()->json($response, 200);
        }

        //is valid
        // is valid
        $user = Auth::user(); //user data
        $employee = $user->employee; // user's employee data


        if ($employee && $employee->hasResigned != 1) {

            $purchaseOrder = StoragePurchaseOrders::find($request->id);

            if ($purchaseOrder) {

                $response['isFailed'] = false;
                $response['message'] = 'Success';
                $response['purchaseOrder'] = fractal($purchaseOrder, new StoragePurchaseOrderTransformer())->includePurchaseOrderItems();

                return response()->json($response, 200);

            } else {

                $response['isFailed'] = true;
                $response['message'] = 'No purchase order found';
                return response()->json($response, 200);

            }

        } else {
            /* Return error response */
            $response['isFailed'] = true;
            $response['message'] = 'Permission denied';
            return response()->json($response, 200);
        }

    }

    public function searchPurchaseOrder(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(), []);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }

        // is valid
        $user = Auth::user(); //user data
        $employee = $user->employee; // user's employee data


        if ($employee && $employee->hasResigned != 1) {


            $purchaseOrders = StoragePurchaseOrders::orderBy('id', 'desc')->paginate(30); // default get all

            if ($request->v != '' && $request->v != null) {

                $search = $request->v;

                $purchaseOrders = StoragePurchaseOrders::where(function ($query) use ($search) {
                    $query->where('purchaseOrderNumber', 'like', '%' . $search . '%')
                        ->orWhereHas('requisition', function ($query) use ($search) {//approval no
                            $query->where('approvalNumber', 'like', '%' . $search . '%');
                        })
                        ->orWhereHas('supplier', function ($query) use ($search) { //supplier
                            $query->where('name', 'like', '%' . $search . '%');
                        })->orWhereHas('warehouse', function ($query) use ($search) { //warehouse
                            $query->where('name', 'like', '%' . $search . '%');
                        })->orWhere('date', 'like', '%' . $search . '%');//date

                })->orderBy('id', 'desc')->paginate(30); // default get all
            }


            if ($purchaseOrders) {

                $response['isFailed'] = false;
                $response['message'] = 'Success';
                $response['purchaseOrders'] = fractal($purchaseOrders, new StoragePurchaseOrderTransformer());

                return response()->json($response, 200);

            } else {

                $response['isFailed'] = true;
                $response['message'] = 'No purchase order found';
                return response()->json($response, 200);

            }

        } else {
            /* Return error response */
            $response['isFailed'] = true;
            $response['message'] = 'Permission denied';
            return response()->json($response, 200);
        }

    }

    public function updatePurchaseOrder(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(), [
            'purchaseOrderId' => 'required',
            'statusId' => 'required'
        ]);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }

        //is valid

        $purchaseOrder = StoragePurchaseOrders::find($request->purchaseOrderId);

        if ($purchaseOrder) {

            $purchaseOrder->statusId = $request->statusId;

            if ($purchaseOrder->save()) { /* Success response */

                // Update approval/requisition status as well
                if ($purchaseOrder->withRequisition && $purchaseOrder->requisitionId != null) {

                    $requisitionApprovalStatus = '';

                    switch ($request->statusId) {
                        case ConfigCodes::$PURCHASE_ORDER_STATUS['OPEN']:
                            $requisitionApprovalStatus = ConfigCodes::$REQUISITION_APPROVAL_STATUS['IN_PROCESS'];
                            break;
                        case ConfigCodes::$PURCHASE_ORDER_STATUS['CLOSED']:
                            $requisitionApprovalStatus = ConfigCodes::$REQUISITION_APPROVAL_STATUS['FINISH'];
                            break;
                        case ConfigCodes::$PURCHASE_ORDER_STATUS['PENDING']:
                            $requisitionApprovalStatus = ConfigCodes::$REQUISITION_APPROVAL_STATUS['WAITING'];
                            break;
                        case ConfigCodes::$PURCHASE_ORDER_STATUS['CANCELED']:
                            $requisitionApprovalStatus = ConfigCodes::$REQUISITION_APPROVAL_STATUS['FINISH'];
                            break;
                        default:
                            break;
                    }

                    if ($requisitionApprovalStatus != '') {
                        $requisition = StorageRequisition::find($purchaseOrder->requisitionId);
                        if ($requisition) {
                            $requisition->approvalId = $requisitionApprovalStatus;

                            if ($requisition->save()) { /* Success response */

                                //Dispatch job to notify requester their request is in process
                                NotifyRequestTracking::dispatch(
                                    $requisition->id, //requisition ID
                                    Auth::user(),//user sender
                                    'New update on your requisition #' . $requisition->requisitionNumber, //message
                                    url('storage/requisition/history') //url to click
                                )
                                    ->onConnection('database')->onQueue('broadcaster');

                                $response['isFailed'] = false;
                                $response['message'] = 'Status has been updated successfully';
                                return response()->json($response, 200);

                            } else { /* Success with  Error response */
                                $response['isFailed'] = false;
                                $response['message'] = 'PO Status update. (err:Unable to update requisition status)';
                                return response()->json($response, 200);
                            }
                        } else {/* Success with Error response */
                            $response['isFailed'] = false;
                            $response['message'] = 'PO Status update. (err:Unable to find requisition)';
                            return response()->json($response, 200);
                        }
                    } else {
                        $response['isFailed'] = false;
                        $response['message'] = 'Status has been updated successfully';
                        return response()->json($response, 200);
                    }

                } else { /* Success response */
                    $response['isFailed'] = false;
                    $response['message'] = 'Status has been updated successfully';
                    return response()->json($response, 200);
                }


            } else { /* Error response */

                $response['isFailed'] = true;
                $response['message'] = 'Unable to save purchase order status';
                return response()->json($response, 200);

            }
        } else { /* Error response */
            $response['isFailed'] = true;
            $response['message'] = 'Unable to find purchase order data';
            return response()->json($response, 200);
        }

    }

    public function addItemTrack(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'estimatedDateArrival' => 'required',
            'estimatedTimeArrival' => 'required'
        ]);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }

        //is valid

        $insert = StoragePurchaseOrderItemTrack::updateOrCreate(
            [
                'purchaseOrderItemId' => $request->id
            ],
            [
                'estimatedDateArrival' => $request->estimatedDateArrival,
                'estimatedTimeArrival' => $request->estimatedTimeArrival,
                'notes' => $request->notes
            ]
        );

        if ($insert) {
            $response['isFailed'] = false;
            $response['message'] = 'Item track has been created successfully';
            return response()->json($response, 200);
        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to create item track';
            return response()->json($response, 200);
        }
    }

    public function generatePDF(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {

            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';

            return response()->json($response, 200);
        }

        //is valid
        // is valid
        $user = Auth::user(); //user data
        $employee = $user->employee; // user's employee data


        if ($employee && $employee->hasResigned != 1) {

            $purchaseOrder = StoragePurchaseOrders::find($request->id);
            $purchaseOrderItems = StoragePurchaseOrderItems::orderBy('id', 'desc')
                ->where('purchaseOrderId', $purchaseOrder->id)
                ->get();

            if ($purchaseOrder) {

                //INFORMATION

                $signatureName = GlobalConfig::$PURCHASE_ORDER_INFO['SIGNATURE_NAME'];
                $signatureImg = GlobalConfig::$PURCHASE_ORDER_INFO['SIGNATURE_IMG'];
                $signaturePosition = GlobalConfig::$PURCHASE_ORDER_INFO['POSITION'];


                $pdf = PDF::loadView('layouts.pdf.purchase_order', compact('purchaseOrder', 'purchaseOrderItems', 'signatureName', 'signatureImg', 'signaturePosition'))
                    ->setPaper('a4')->setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);;
                return $pdf->stream($purchaseOrder->purchaseOrderNumber . '.pdf');

            } else {

                /* Return error response */
                $response['isFailed'] = true;
                $response['message'] = 'Unable to find purchase order';
                return response()->json($response, 200);
            }

        } else {
            /* Return error response */
            $response['isFailed'] = true;
            $response['message'] = 'Permission denied';
            return response()->json($response, 200);
        }

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

    public function warehouseList()
    {
        $response = array();

        $suppliers = StorageWarehouses::orderBy('name', 'asc')->get();

        $response['isFailed'] = false;
        $response['message'] = 'Success';
        $response['warehouses'] = fractal($suppliers, new WarehouseTransformer());

        return response()->json($response, 200);
    }

    public function searchWarehouse(Request $request)
    {
        $response = array();

        $search = '';
        if ($request->get('v') != '' && $request->get('v') != null) {
            $search = $request->get('v');
        }

        $suppliers = StorageWarehouses::where('isDeleted', 0)
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
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

    public function getApprovalDetail(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(), ['no' => 'required']);


        if ($validator->fails()) {

            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';

            return response()->json($response, 200);
        }

        //is valid

        $requisition = StorageRequisition::where('approvalNumber', $request->no)->first();

        if ($requisition) {

            $response['isFailed'] = false;
            $response['message'] = 'Success';
            $response['requisition'] = fractal($requisition, new StorageRequisitionListTransformer())->includeRequisitionItems()->includeDeliveryWarehouse();

            return response()->json($response, 200);

        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to find requisition';
            return response()->json($response, 200);
        }

    }

}