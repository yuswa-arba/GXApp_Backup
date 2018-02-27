<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Storage\Misc;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ListController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function itemList()
    {
        
    }

    public function itemCategoryList()
    {

    }

    public function itemTypeList()
    {

    }

    public function shipmentList()
    {

    }

    public function supplierList()
    {

    }

    public function warehouseList()
    {

    }

    public function unitList()
    {

    }

}
