<?php

namespace App\Storage\Logics\Requisition;

use App\Employee\Models\MasterEmployee;
use App\Employee\Transformers\EmployeeListTransfomer;
use App\Http\Controllers\BackendV1\Helpdesk\Traits\Configs;
use App\Storage\Models\StorageItems;
use App\Storage\Transformers\StorageItemDetailTransformer;
use App\Traits\GlobalUtils;
use Illuminate\Support\Facades\Log;

class GetShopItemListLogic extends GetListUseCase
{

    use GlobalUtils;

    public function handleGetList($request)
    {
        $response = array();

        $query = '';

        if ($request->typeCode != '' && $request->typeCode != null) {

            if ($query != '') { // add 'and' if its the first query for SQL Query syntax purposes
                $query .= ' and ';
            }

            $rawQueryType = 'itemTypeCode = "'.$request->typeCode.'"';

            $query .= $rawQueryType;
        }

        if ($request->categoryCode != '' && $request->categoryCode != null) {

            if ($query != '') { // add 'and' if its the first query for SQL Query syntax purposes
                $query .= ' and ';
            }

            $rawQueryCategory = ' categoryCode = "' . $request->categoryCode.'"';

            $query .= $rawQueryCategory;
        }

        if ($request->accNo != '' && $request->accNo != null) {

            if ($query != '') { // add 'and' if its the first query for SQL Query syntax purposes
                $query .= ' and ';
            }

            $rawQueryAccNo = ' accountingNumber = "' . $request->accNo.'"';

            $query .= $rawQueryAccNo;
        }

        if ($request->status != '' && $request->status != null) {

            if ($query != '') { // add 'and' if its the first query for SQL Query syntax purposes
                $query .= ' and ';
            }

            $rawQueryStatus = ' statusId = "' . $request->status.'"';

            $query .= $rawQueryStatus;
        }

        $items = StorageItems::whereNotNull('itemCode')->where('isDeleted',0)->paginate(50);

        if ($query != '') {

//            Log::info('raw query called: ' . $query);

            $items = StorageItems::whereNotNull('itemCode')
                ->where('isDeleted',0)
                ->whereRaw($query)
                ->paginate(50);
        }

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


    }
}