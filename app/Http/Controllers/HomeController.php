<?php

namespace larashop\Http\Controllers;

use larashop\Product;
use Illuminate\Http\Request;
use larashop\Http\Requests;

class HomeController extends Controller
{
    public function index(Product $product)
    {
        $products = $product->paginate(8);

        return view('shop.index')->withProducts($products);
    }

    public function search(Request $request, Product $product)
    {
        $search = $request->input('search');

        $products = $product->search($search)->paginate(8);

        return view('shop.results')->withProducts($products);
        
    }
}
