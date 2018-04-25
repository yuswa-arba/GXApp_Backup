<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Storage\Inventory;

use App\Http\Controllers\Controller;
use App\Storage\Logics\Inventory\InsertToInventoryLogic;
use App\Storage\Models\StorageGeneralInventory;
use App\Storage\Models\StoragePurchaseOrders;
use App\Storage\Transformers\StorageGeneralInventoryListTransformer;
use App\Storage\Transformers\StoragePurchaseOrderInventoryTransformer;
use App\Traits\GlobalUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GeneralInventoryController extends Controller
{

    use GlobalUtils;

    public function __construct()
    {

    }


    public function getList(Request $request)
    {
        $response = array();

        // is valid
        $user = Auth::user(); //user data
        $employee = $user->employee; // user's employee data


        if ($employee && $employee->hasResigned != 1) {

            $generalInventory = StorageGeneralInventory::orderBy('id', 'desc')->paginate(50); //default get all

            if ($generalInventory) {
                $response['isFailed'] = false;
                $response['message'] = 'Success';
                $response['generalInventory'] = fractal($generalInventory, new StorageGeneralInventoryListTransformer());

                return response()->json($response, 200);

            } else {

                $response['isFailed'] = true;
                $response['message'] = 'No General Inventory found';
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
