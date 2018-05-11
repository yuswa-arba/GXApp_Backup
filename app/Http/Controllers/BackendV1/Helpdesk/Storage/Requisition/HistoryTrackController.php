<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Storage\Requisition;

use App\Http\Controllers\Controller;
use App\Storage\Logics\Requisition\GetShopItemDetailLogic;
use App\Storage\Models\StorageRequisition;
use App\Storage\Transformers\StoragePurchaseOrderExcludePriceTransformer;
use App\Storage\Transformers\StoragePurchaseOrderTransformer;
use App\Storage\Transformers\StorageRequisitionListTransformer;
use App\Traits\GlobalUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HistoryTrackController extends Controller
{

    use GlobalUtils;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function requisitionHistory(Request $request)
    {
        $response = array();
        // is valid

        $user = Auth::user(); //user data
        $employee = $user->employee; // user's employee data

        $approvalId = ''; //default approval id empty = get all

        if ($request->sortApproval != null && $request->sortApproval != '') {
            $approvalId = $request->sortApproval;
        }

        //get all
        $requisitions = StorageRequisition::where('requesterEmployeeId', $employee->id)->orderBy('id','desc')->paginate(10);

        //get based on approval id status
        if($approvalId!=''){

            $requisitions = StorageRequisition::where('requesterEmployeeId', $employee->id)
                ->where('approvalId', $approvalId)
                ->orderBy('id','desc')
                ->paginate(10);
        }

        if ($requisitions) {

            $response['isFailed'] = false;
            $response['message'] = 'Success';
            $response['requisitions'] = fractal($requisitions, new StorageRequisitionListTransformer())->includeRequisitionItems()->includeDeliveryWarehouse();

            return response()->json($response, 200);

        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to find requisition';
            return response()->json($response, 200);
        }


    }

    public function searchRequisitionHistory(Request $request)
    {
        $response = array();

        $user = Auth::user(); //user data
        $employee = $user->employee; // user's employee data


        $search = $request->v;

        if ($search != '') {

            $requisitions = StorageRequisition::where('requesterEmployeeId', $employee->id)
                ->where(function($query)use($search){
                    $query->where('requisitionNumber','like','%'.$search.'%');
                })
                ->paginate(10);

        } else {
            $requisitions = StorageRequisition::where('requesterEmployeeId', $employee->id)->paginate(10);
        }

        $response['isFailed'] = false;
        $response['message'] = 'Success';
        $response['requisitions'] = fractal($requisitions, new StorageRequisitionListTransformer())
            ->includeRequisitionItems()
            ->includeDeliveryWarehouse();

        return response()->json($response, 200);
    }

    public function requisitionTrackDetail(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(),[
            'id'=>'required'
        ]);

        if($validator->fails()){
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response,200);
        }

        //is valid

        $requisition =  StorageRequisition::find($request->id);

        if($requisition){

            $response['isFailed'] = false;
            $response['message'] = 'Success';
            $response['requisition'] =  fractal($requisition, new StorageRequisitionListTransformer())->includeRequisitionItems()->includeDeliveryWarehouse();
            $response['purchaseOrder'] = fractal($requisition->purchaseOrder,new StoragePurchaseOrderExcludePriceTransformer())->includePurchaseOrderItems();

            return response()->json($response,200);

        } else { /* Error repsonse */
            $response['isFailed'] = true;
            $response['message'] = 'Unable to find requisition';
            return response()->json($response,200);
        }




    }
}