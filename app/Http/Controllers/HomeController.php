<?php

namespace larashop\Http\Controllers;

use larashop\Product;
use Illuminate\Http\Request;
use larashop\Http\Requests;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::paginate(8);

        return view('shop.index', ['products' => $products]);
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        $products = Product::search($search)->paginate(8);

        return view('shop.results', ['products' => $products]);
        
    }
}
