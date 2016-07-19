<?php

namespace larashop\Http\Controllers;

use larashop\Product;
use larashop\Order;
use Illuminate\Http\Request;
use Auth;
use DB;

use larashop\Http\Requests;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function products()
    {
        $products = Product::all();

        return view('admin.products', ['products' => $products]);
    }

    public function getCreate(){

        return view('admin.create');
    }

    public function postCreate(Request $request)
    {
        $this->validate($request, [
            'title' =>  'required|min:5',
            'slug'  =>  'required',
            'description'   =>  'required',
            'price' =>  'required',
            'image' =>  'required',
            'stock' =>  'required'
        ]);

        $input = $request->all();

        Product::create($input);

        return redirect()->route('admin.products');
    }

    public function editProduct($id)
    {
        $product = Product::find($id);

        return view('admin.edit', ['product' => $product]);
    }

    public function updateProduct($id, Request $request)
    {
        $product = Product::find($id);

        $this->validate($request, [
            'title' =>  'required|min:5',
            'slug'  =>  'required',
            'description'   =>  'required',
            'price' =>  'required',
            'image' =>  'required',
            'stock' =>  'required'
        ]);

        $input = $request->all();

        $product->update($input);

        return redirect()->back();
    }

    public function deleteProduct($id) {
        $product = Product::find($id);

        $order_product = DB::table('order_product')->where('product_id', $id);

        $order_product->delete();

        $product->delete();

        return redirect()->back();
    }
}