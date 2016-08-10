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

    public function search(Request $request)
    {
        $search = $request->input('search');

        $product = Product::where("title", "LIKE", "%".$search."%")->get();

        if(count($product) > 0)
        {
            return view('shop.results')->withDetails($product)->withQuery($search);
        } else {
            return view('shop.results')->withMessage('No details found. Try to search again!');
        }
        
    }
}