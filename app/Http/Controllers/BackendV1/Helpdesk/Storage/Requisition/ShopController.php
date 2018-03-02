<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Storage\Requisition;

use App\Components\Models\UnitOfMeasurements;
use App\Components\Transformers\UnitOfMeasurementTransformer;
use App\Http\Controllers\BackendV1\Helpdesk\Traits\Configs;
use App\Http\Controllers\Controller;
use App\Storage\Logics\Item\CreateItemLogic;
use App\Storage\Logics\Item\GetItemListLogic;
use App\Storage\Logics\Requisition\GetShopItemListLogic;
use App\Storage\Models\StorageItems;
use App\Storage\Models\StorageItemsCategory;
use App\Storage\Models\StorageItemTypes;
use App\Storage\Models\StorageShipments;
use App\Storage\Models\StorageSuppliers;
use App\Storage\Models\StorageWarehouses;
use App\Storage\Transformers\BasicCodeNameTransformer;
use App\Storage\Transformers\ShipmentTransformer;
use App\Storage\Transformers\StorageItemDetailTransformer;
use App\Storage\Transformers\SupplierTransformer;
use App\Storage\Transformers\WarehouseTransformer;
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

    public function searchItem(Request $request)
    {

        $items = StorageItems::where('itemCode', 'like', '%' . $request->search . '%')
            ->where('name', 'like', '%' . $request->search . '%')
            ->get();

        if($items){

            $response['isFailed'] = false;
            $response['message'] = 'Success';
            $response['items']= fractal($items, new StorageItemDetailTransformer());

            return response()->json($response,200);

        } else {

            $response['isFailed'] = true;
            $response['message'] = 'Items not found';

            return response()->json($response,200);

        }

    }




}
