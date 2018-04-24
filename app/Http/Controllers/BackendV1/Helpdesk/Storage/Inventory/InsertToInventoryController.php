<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Storage\Inventory;

use App\Http\Controllers\Controller;
use App\Storage\Models\StoragePurchaseOrders;
use App\Storage\Transformers\StoragePurchaseOrderInventoryTransformer;
use App\Traits\GlobalUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class InsertToInventoryController extends Controller
{

    use GlobalUtils;

    public function __construct()
    {

    }


    public function purchaseOrderInventoryDetail(Request $request)
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
                $response['purchaseOrder'] = fractal($purchaseOrder, new StoragePurchaseOrderInventoryTransformer())->includePurchaseOrderItems();

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






}
