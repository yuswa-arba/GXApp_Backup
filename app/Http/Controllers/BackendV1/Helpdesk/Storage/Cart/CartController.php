<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Storage\Cart;

use App\Http\Controllers\Controller;
use App\Storage\Models\StorageRequestCart;
use App\Storage\Transformers\StorageItemBriefDetailTransformer;
use App\Storage\Transformers\StorageItemInsideCartDetailTransformer;
use App\Traits\GlobalUtils;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class CartController extends Controller
{

    use GlobalUtils;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getTotalItemInCart()
    {
        $response = array();

        $user = Auth::user(); //user data
        $employee = $user->employee; // user's employee data

        if ($employee && $employee->hasResigned != 1) {

            $totalItem = StorageRequestCart::where('employeeId', $employee->id)->count();

            $response['isFailed'] = false;;
            $response['message'] = 'Success';
            $response['totalItemInCart'] = $totalItem;

            return response()->json($response, 200);

        } else {
            /* Return error response */
            $response['isFailed'] = true;
            $response['message'] = 'Permission denied';
            return response()->json($response, 200);
        }
    }

    public function itemInsideCartList(Request $request)
    {
        $response = array();

        $user = Auth::user(); //user data
        $employee = $user->employee; // user's employee data

        if ($employee && $employee->hasResigned != 1) {

            $itemInsideCart = StorageRequestCart::where('employeeId', $employee->id)->get();

            $response['isFailed'] = false;;
            $response['message'] = 'Success';
            $response['itemInsideCart'] = fractal($itemInsideCart, new StorageItemInsideCartDetailTransformer());

            return response()->json($response, 200);

        } else {
            /* Return error response */
            $response['isFailed'] = true;
            $response['message'] = 'Permission denied';
            return response()->json($response, 200);
        }

    }

    public function addToCart(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(), [
            'itemId' => 'required',
            'amount' => 'required'
        ]);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }

        //is valid

        $user = Auth::user(); //user data
        $employee = $user->employee; // user's employee data

        if ($employee && $employee->hasResigned != 1) {

            $insert = StorageRequestCart::updateOrCreate(
                [
                    'employeeId' => $employee->id,
                    'itemId' => $request->itemId
                ],
                [
                    'amount' => $request->amount,
                    'notes' => $request->notes,
                    'insertedAt' => Carbon::now()->format('d/m/Y')
                ]
            );

            if ($insert) {

                $response['isFailed'] = false;
                $response['message'] = 'Added to cart successfully';
                $response['item'] = fractal($insert, new StorageItemInsideCartDetailTransformer());

                return response()->json($response, 200);
            } else {
                $response['isFailed'] = true;
                $response['message'] = 'Unable to insert item to cart';
                return response()->json($response, 200);
            }

        } else {
            /* Return error response */
            $response['isFailed'] = true;
            $response['message'] = 'Permission denied';
            return response()->json($response, 200);
        }


    }

    public function removeFromCart(Request $request)
    {

        $response = array();

        $validator = Validator::make($request->all(), [
            'itemCartId' => 'required'
        ]);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }

        //is valid

        $user = Auth::user(); //user data
        $employee = $user->employee; // user's employee data

        if ($employee && $employee->hasResigned != 1) {

            $item = StorageRequestCart::where('id', $request->itemCartId)->where('employeeId', $employee->id)->first();

            if ($item) {

                $remove = $item->delete();

                if ($remove) {

                    $response['isFailed'] = false;
                    $response['message'] = 'Item has been removed successfully';
                    return response()->json($response, 200);

                } else {
                    $response['isFailed'] = true;
                    $response['message'] = 'Unable to remove item from cart';
                    return response()->json($response, 200);
                }
            } else {
                $response['isFailed'] = true;
                $response['message'] = 'Unable to find item in cart';
                return response()->json($response, 200);
            }


        } else {
            /* Return error response */
            $response['isFailed'] = true;
            $response['message'] = 'Permission denied';
            return response()->json($response, 200);
        }

    }

    public function removeAllFromCart(Request $request)
    {
        $response = array();

        //is valid

        $user = Auth::user(); //user data
        $employee = $user->employee; // user's employee data

        if ($employee && $employee->hasResigned != 1) {

            $remove = StorageRequestCart::where('employeeId',$employee->id)->delete();

            if ($remove) {

                $response['isFailed'] = false;
                $response['message'] = 'All items has been removed successfully';
                return response()->json($response, 200);

            } else {
                $response['isFailed'] = true;
                $response['message'] = 'Unable to remove item from cart';
                return response()->json($response, 200);
            }

        } else {
            /* Return error response */
            $response['isFailed'] = true;
            $response['message'] = 'Permission denied';
            return response()->json($response, 200);
        }
    }

    public function updateItemAmountInCart(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(), [
            'itemCartId' => 'required',
            'amount' => 'required'
        ]);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }

        //is valid

        $cartItem = StorageRequestCart::find($request->itemCartId);

        if ($cartItem) {

            $cartItem->amount = $request->amount;

            if ($cartItem->save()) {

                $response['isFailed'] = false;
                $response['message'] = 'Success';
                return response()->json($response, 200);

            } else {
                $response['isFailed'] = true;
                $response['message'] = 'Unable to save amount';
                return response()->json($response, 200);
            }

        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to find item in cart';
            return response()->json($response, 200);

        }

    }

    public function updateItemNotesInCart(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(), [
            'itemCartId' => 'required',
            'notes' => 'required'
        ]);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }

        //is valid

        $cartItem = StorageRequestCart::find($request->itemCartId);

        if ($cartItem) {

            $cartItem->notes = $request->notes;

            if ($cartItem->save()) {

                $response['isFailed'] = false;
                $response['message'] = 'Success';
                return response()->json($response, 200);

            } else {
                $response['isFailed'] = true;
                $response['message'] = 'Unable to save notes';
                return response()->json($response, 200);
            }

        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to find item in cart';
            return response()->json($response, 200);

        }
    }

}
