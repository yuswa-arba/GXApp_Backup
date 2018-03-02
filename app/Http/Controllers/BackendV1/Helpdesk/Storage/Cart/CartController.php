<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Storage\Cart;

use App\Http\Controllers\Controller;
use App\Traits\GlobalUtils;
use Illuminate\Http\Request;


class CartController extends Controller
{

    use GlobalUtils;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function itemInsideCartList(Request $request)
    {

    }

    public function addToCart(Request $request)
    {

    }

    public function removeFromCart(Request $request)
    {

    }

}
