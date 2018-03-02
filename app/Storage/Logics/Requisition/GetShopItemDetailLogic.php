<?php

namespace App\Storage\Logics\Requisition;

use App\Employee\Models\MasterEmployee;
use App\Employee\Transformers\EmployeeListTransfomer;
use App\Http\Controllers\BackendV1\Helpdesk\Traits\Configs;
use App\Storage\Models\StorageItems;
use App\Storage\Transformers\StorageItemDetailTransformer;
use App\Traits\GlobalUtils;
use Illuminate\Support\Facades\Log;

class GetShopItemDetailLogic extends GetDetailUseCase
{

    use GlobalUtils;

    public function handle($request)
    {
        $response = array();

    }
}