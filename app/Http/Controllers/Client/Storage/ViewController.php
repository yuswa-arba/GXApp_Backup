<?php

namespace App\Http\Controllers\Client\Storage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ViewController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function cart()
    {
        
    }

    public function items()
    {
     return view('pages.storage.misc.items');
    }

    public function itemCategories(){
        return view('pages.storage.misc.itemCategories');
    }

    public function itemTypes()
    {
        return view('pages.storage.misc.itemTypes');
    }

    public function shipments()
    {
        return view('pages.storage.misc.shipments');
    }

    public function suppliers()
    {
        return view('pages.storage.misc.suppliers');
    }

    public function warehouses()
    {
        return view('pages.storage.misc.warehouses');
    }

    public function units()
    {
        return view('pages.storage.misc.units');
    }
}
