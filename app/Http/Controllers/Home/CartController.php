<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    /**
    * Display a listing of the product in Cart.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        return view('public.pages.cart');
    }
}
