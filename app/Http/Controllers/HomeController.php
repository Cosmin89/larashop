<?php

namespace larashop\Http\Controllers;

use larashop\Product;
use Illuminate\Http\Request;

use larashop\Http\Requests;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return view('shop.index', ['products' => $products]);
    }
}