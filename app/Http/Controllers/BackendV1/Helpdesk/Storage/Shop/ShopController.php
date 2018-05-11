<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Storage\Shop;

use App\Http\Controllers\Controller;
use App\Storage\Logics\Requisition\GetShopItemListLogic;
use App\Storage\Models\StorageItems;
use App\Storage\Transformers\StorageItemBriefDetailTransformer;
use App\Storage\Transformers\StorageItemDetailTransformer;
use App\Traits\GlobalUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShopController extends Controller
{

    use GlobalUtils;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function itemList(Request $request)
    {
        return GetShopItemListLogic::getData($request);
    }

    public function itemDetail(Request $request)
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

        $item = StorageItems::find($request->id);

        if ($item) {
            $response['isFailed'] = false;
            $response['message'] = 'Success';
            $response['item'] = fractal($item , new StorageItemBriefDetailTransformer());

            return response()->json($response, 200);
        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to find item detail';

            return response()->json($response, 200);
        }

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
                ->paginate(50); //paginate it

            if ($items) {

                $response['isFailed'] = false;
                $response['message'] = 'Success';
                $response['items'] = fractal($items, new StorageItemDetailTransformer());

                return response()->json($response, 200);

            } else {

                $response['isFailed'] = true;
                $response['message'] = 'Items not found';

                return response()->json($response, 200);

            }

        } else {


            return GetShopItemListLogic::getData($request);

        }

    }

}
