<?php

namespace App\Storage\Logics\PurchaseOrder;

use App\Employee\Models\MasterEmployee;
use App\Employee\Transformers\EmployeeListTransfomer;
use App\Http\Controllers\BackendV1\Helpdesk\Traits\Configs;
use App\Storage\Models\StorageItems;
use App\Storage\Transformers\StorageItemDetailTransformer;
use App\Traits\GlobalUtils;

class CreatePurchaseOrderLogic extends CreateUseCase
{

    use GlobalUtils;


    public function handleCreate($request)
    {

    }
}