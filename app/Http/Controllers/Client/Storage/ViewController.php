<?php

namespace App\Http\Controllers\Client\Storage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ViewController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function items()
    {
        if (Auth::user()->hasPermissionTo('access storage setting')) {
            return view('pages.storage.misc.items');
        } else {
            return redirect()->back();
        }

    }

    public function itemCategories()
    {
        if (Auth::user()->hasPermissionTo('access storage setting')) {
            return view('pages.storage.misc.itemCategories');
        } else {
            return redirect()->back();
        }
    }

    public function itemTypes()
    {
        if (Auth::user()->hasPermissionTo('access storage setting')) {
            return view('pages.storage.misc.itemTypes');
        } else {
            return redirect()->back();
        }
    }

    public function shipments()
    {
        if (Auth::user()->hasPermissionTo('access storage setting')) {
            return view('pages.storage.misc.shipments');
        } else {
            return redirect()->back();
        }
    }

    public function suppliers()
    {
        if (Auth::user()->hasPermissionTo('access storage setting')) {
            return view('pages.storage.misc.suppliers');
        } else {
            return redirect()->back();
        }
    }

    public function warehouses()
    {
        if (Auth::user()->hasPermissionTo('access storage setting')) {
            return view('pages.storage.misc.warehouses');
        } else {
            return redirect()->back();
        }
    }

    public function units()
    {
        if (Auth::user()->hasPermissionTo('access storage setting')) {
            return view('pages.storage.misc.units');
        } else {
            return redirect()->back();
        }
    }

    public function requisitionShop()
    {
        return view('pages.storage.requisition.shop');
    }

    public function requisitionCart()
    {
        return view('pages.storage.requisition.cart');
    }
}
