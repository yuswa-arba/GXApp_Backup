<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Storage\Requisition;

use App\Http\Controllers\BackendV1\API\Traits\ConfigCodes;
use App\Http\Controllers\Controller;
use App\Storage\Jobs\NotifyAdminsNewRequisition;
use App\Storage\Models\StorageRequestCart;
use App\Storage\Models\StorageRequisition;
use App\Storage\Models\StorageRequisitionItems;
use App\Storage\Transformers\StorageItemInsideCartDetailTransformer;
use App\Traits\GlobalUtils;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RequisitionController extends Controller
{

    use GlobalUtils;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function itemsBeingRequestedList(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(),[
            'itemCartIds'=>'required'
        ]);

        if($validator->fails()){
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response,200);
        }

        if (count($request->itemCartIds) == 0) {
            $response['isFailed'] = true;
            $response['message'] = 'Items cannot be empty';
            return response()->json($response, 200);
        }

        // is valid

        $user = Auth::user(); //user data
        $employee = $user->employee; // user's employee data

        if ($employee && $employee->hasResigned != 1) {

            $items = StorageRequestCart::where('employeeId', $employee->id)
                                       ->whereIn('id',$request->itemCartIds)
                                       ->get();

            $response['isFailed'] = false;;
            $response['message'] = 'Success';
            $response['itemsBeingRequested'] = fractal($items, new StorageItemInsideCartDetailTransformer());

            return response()->json($response, 200);

        } else {
            /* Return error response */
            $response['isFailed'] = true;
            $response['message'] = 'Permission denied';
            return response()->json($response, 200);
        }
    }

    public function createRequisition(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(), [
            'divisionId' => 'required',
            'deliveryWarehouseId' => 'required',
            'dateNeededBy' => 'required',
            'itemCartIds' => 'required'
        ]);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }


        if (count($request->itemCartIds) == 0) {
            $response['isFailed'] = true;
            $response['message'] = 'Items cannot be empty';
            return response()->json($response, 200);
        }

        $user = Auth::user(); //user data
        $employee = $user->employee; // user's employee data

        //is valid

        if ($employee && $employee->hasResigned != 1) {

            $latestRequisition  = StorageRequisition::orderBy('id','desc')->first();
            $incrementNumber = $latestRequisition?($latestRequisition->id+1): 1;//get latest id and add by 1
            $requisitionNumber = Carbon::now()->format('Ymd') . $this->zeroPrefix($incrementNumber, 3); //  yyyymmdd001 format


            //Create requisition
            $createRequisition = StorageRequisition::create([
                'requisitionNumber' => $requisitionNumber,
                'requestedAt' => Carbon::now()->format('d/m/Y'),
                'requestedBy'=>$employee->givenName . ' ' . $employee->surname,
                'requesterEmployeeId'=>$employee->id,
                'divisionId'=>$request->divisionId,
                'deliveryWarehouseId'=>$request->deliveryWarehouseId,
                'description'=>$request->description,
                'dateNeededBy'=>$request->dateNeededBy,
                'approvalId'=>ConfigCodes::$REQUISITION_APPROVAL_STATUS['WAITING'] // waiting for approval ( source: storageRequisitionApproval table)
            ]);

            if($createRequisition){

                //Move from cart to requisition items table
                foreach ($request->itemCartIds  as $itemCartId){

                    //Item in cart
                    $itemInCart = StorageRequestCart::find($itemCartId);

                    if($itemInCart){

                        //insert to requisition item
                        $insertToRequisitionItems = StorageRequisitionItems::create([
                            'requisitionId'=>$createRequisition->id,
                            'employeeId'=>$itemInCart->employeeId,
                            'itemId'=>$itemInCart->itemId,
                            'amount'=>$itemInCart->amount,
                            'notes'=>$itemInCart->notes,
                            'insertedAt'=>Carbon::now()->format('d/m/Y'),
                            'isApproved'=>0 //default to false
                        ]);


                        //remove from cart
                        if($insertToRequisitionItems){
                            $itemInCart->delete();
                        }
                    }
                }

                //Dispatch job to notify someone has requested some items
                //Send email to admins
                NotifyAdminsNewRequisition::dispatch($createRequisition->id,$user)->onConnection('database')->onQueue('broadcaster');

                // Return success response
                $response['isFailed'] = false;
                $response['message'] = 'Requisition has been created successfully';
                return response()->json($response,200);

            } else {
                /* Return error response */
                $response['isFailed'] = true;
                $response['message'] = 'Unable to create requisition';
                return response()->json($response,200);
            }


        } else {
            /* Return error response */
            $response['isFailed'] = true;
            $response['message'] = 'Permission denied';
            return response()->json($response, 200);
        }


    }

}
