<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Storage\Admin;

use App\Http\Controllers\BackendV1\API\Traits\ConfigCodes;
use App\Http\Controllers\Controller;
use App\Storage\Jobs\NotifyRequestTracking;
use App\Storage\Models\StorageRequisition;
use App\Storage\Models\StorageRequisitionItems;
use App\Storage\Transformers\StorageRequisitionListTransformer;
use App\Traits\GlobalUtils;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApprovalController extends Controller
{

    use GlobalUtils;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('auth.admin');
    }

    public function requisitionList(Request $request)
    {
        $response = array();
        // is valid

        $user = Auth::user(); //user data
        $employee = $user->employee; // user's employee data

        $approvalId = ConfigCodes::$REQUISITION_APPROVAL_STATUS['WAITING']; //default approval id

        if ($request->sortApproval != null && $request->sortApproval != '') {
            $approvalId = $request->sortApproval;
        }


        if ($employee && $employee->hasResigned != 1) {

            $requisitions = StorageRequisition::where('approvalId', $approvalId)->paginate(10);

            if ($requisitions) {

                $response['isFailed'] = false;
                $response['message'] = 'Success';
                $response['requisitions'] = fractal($requisitions, new StorageRequisitionListTransformer())
                    ->includeRequisitionItems()
                    ->includeDeliveryWarehouse();

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

    public function searchRequisitionList(Request $request)
    {
        $response = array();

        $user = Auth::user(); //user data
        $employee = $user->employee; // user's employee data

        if ($employee && $employee->hasResigned != 1) {

            $search = $request->v;

            $approvalId = ConfigCodes::$REQUISITION_APPROVAL_STATUS['WAITING']; //default approval id

            if ($request->sortApproval != null && $request->sortApproval != '') {
                $approvalId = $request->sortApproval;
            }

            if ($search != '') {

                $requisitions = StorageRequisition::where('approvalId', $approvalId)
                    ->where(function ($query) use ($search) {
                        $query->where('requisitionNumber', 'like', '%' . $search . '%');
                    })
                    ->paginate(10);

            } else {
                $requisitions = StorageRequisition::where('approvalId', $approvalId)->paginate(10);
            }

            $response['isFailed'] = false;
            $response['message'] = 'Success';
            $response['requisitions'] = fractal($requisitions, new StorageRequisitionListTransformer())
                ->includeRequisitionItems()
                ->includeDeliveryWarehouse();

            return response()->json($response, 200);

        } else {

            /* Return error response */
            $response['isFailed'] = true;
            $response['message'] = 'Permission denied';
            return response()->json($response, 200);

        }
    }


    /*
     * Approve some/all items in requisition
     * */
    public function editAndApproveRequisition(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(), [
            'requisitionId' => 'required'
        ]);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Misisng required parameters';
            return response()->json($response, 200);
        }

        //is valid

        $user = Auth::user(); //user data
        $employee = $user->employee; // user's employee data

        if ($employee && $employee->hasResigned != 1) {

            $requisition = StorageRequisition::find($request->requisitionId);

            if ($requisition) {
                $requisition->approvalNumber = $requisition->requisitionNumber.'A'; // add approval number
                $requisition->approvalId = ConfigCodes::$REQUISITION_APPROVAL_STATUS['APPROVED'];

                if ($requisition->save()) {

                    $requisitionItemsUpdated= $request->requisitionItemsUpdated;

                    //Update requisition items thats being updated
                    foreach ($requisitionItemsUpdated as $item){
                        StorageRequisitionItems::where('id', $item['id'])->update(['isApproved' => $item['isApproved'],'updatedBy'=>$employee->givenName,'updatedAt'=>Carbon::now()->format('d/m/Y')]);
                    }

                    // Notify user that their requisition has been declined
                    try{
                        NotifyRequestTracking::dispatch(
                            $requisition->id, //requisition ID
                            Auth::user(), //user sender
                            'Your request has been answered #' . $requisition->requisitionNumber, //message
                            url('storage/requisition/history'), //url to click
                            1 //General
                        )
                            ->onConnection('database')
                            ->onQueue('broadcaster');
                    } catch (\Exception $exception){}



                    $response['isFailed'] = false;
                    $response['message'] = 'Requisition has been approved successfully';
                    return response()->json($response,200);


                } else {
                    $response['isFailed'] = true;
                    $response['message'] = 'Unable to save requisition';
                    return response()->json($response, 200);
                }

            } else {
                $response['isFailed'] = true;
                $response['message'] = 'Unable to find requisition data';
                return response()->json($response, 200);
            }
        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Permission Denied';
            return response()->json($response,200);
        }
    }

    /*
     * Approve all items in requisition
     * */
    public function approveRequisition(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(), [
            'requisitionId' => 'required'
        ]);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Misisng required parameters';
            return response()->json($response, 200);
        }

        //is valid

        $user = Auth::user(); //user data
        $employee = $user->employee; // user's employee data

        if ($employee && $employee->hasResigned != 1) {

            $requisition = StorageRequisition::find($request->requisitionId);

            if ($requisition) {
                $requisition->approvalNumber = $requisition->requisitionNumber.'A'; // add approval number
                $requisition->approvalId = ConfigCodes::$REQUISITION_APPROVAL_STATUS['APPROVED'];

                if ($requisition->save()) {

                    $updateRequisitionItems = StorageRequisitionItems::where('requisitionId', $requisition->id)
                        ->update(['isApproved' => 1,'updatedBy'=>$employee->givenName,'updatedAt'=>Carbon::now()->format('d/m/Y')]);

                    if($updateRequisitionItems){

                        // Notify user that their requisition has been accepted
                        try{
                            NotifyRequestTracking::dispatch(
                                $requisition->id, //requisition ID
                                Auth::user(), //user sender
                                'Your request has been accepted #' . $requisition->requisitionNumber, //message
                                url('storage/requisition/history'), //url to click
                                1 //General
                            )
                                ->onConnection('database')
                                ->onQueue('broadcaster');
                        } catch (\Exception $exception){}

                        $response['isFailed'] = false;
                        $response['message'] = 'Requisition has been approved successfully';
                        return response()->json($response,200);

                    } else {
                        $response['isFailed'] = true;
                        $response['message'] = 'Unable to update requisition items';
                        return response()->json($response,200);
                    }


                } else {
                    $response['isFailed'] = true;
                    $response['message'] = 'Unable to save requisition';
                    return response()->json($response, 200);
                }

            } else {
                $response['isFailed'] = true;
                $response['message'] = 'Unable to find requisition data';
                return response()->json($response, 200);
            }
        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Permission Denied';
            return response()->json($response,200);
        }

    }


    /*
     * Decline all item in requisition
     * */
    public function declineRequisition(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(), [
            'requisitionId' => 'required'
        ]);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Misisng required parameters';
            return response()->json($response, 200);
        }

        //is valid

        $user = Auth::user(); //user data
        $employee = $user->employee; // user's employee data

        if ($employee && $employee->hasResigned != 1) {

            $requisition = StorageRequisition::find($request->requisitionId);

            if ($requisition) {

                $requisition->approvalNumber = $requisition->requisitionNumber.'D'; // add approval number
                $requisition->approvalId = ConfigCodes::$REQUISITION_APPROVAL_STATUS['DECLINED'];

                if ($requisition->save()) {

                    $updateRequisitionItems = StorageRequisitionItems::where('requisitionId', $requisition->id)
                        ->update(['isApproved' => 0,'updatedBy'=>$employee->givenName,'updatedAt'=>Carbon::now()->format('d/m/Y')]);

                    if($updateRequisitionItems){

                        // Notify user that their requisition has been declined
                        try{
                            NotifyRequestTracking::dispatch(
                                $requisition->id, //requisition ID
                                Auth::user(), //user sender
                                'Your request has been declined #' . $requisition->requisitionNumber, //message
                                url('storage/requisition/history'), //url to click
                                1 //General
                            )
                                ->onConnection('database')
                                ->onQueue('broadcaster');
                        } catch (\Exception $exception){}

                        $response['isFailed'] = false;
                        $response['message'] = 'Requisition has been declined successfully';
                        return response()->json($response,200);

                    } else {
                        $response['isFailed'] = true;
                        $response['message'] = 'Unable to update requisition items';
                        return response()->json($response,200);
                    }


                } else {
                    $response['isFailed'] = true;
                    $response['message'] = 'Unable to save requisition';
                    return response()->json($response, 200);
                }

            } else {
                $response['isFailed'] = true;
                $response['message'] = 'Unable to find requisition data';
                return response()->json($response, 200);
            }
        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Permission Denied';
            return response()->json($response,200);
        }

    }

}