<?php

namespace larashop\Http\Controllers;

use larashop\Product;
use larashop\Order;
use larashop\User;
use larashop\Role;
use Auth;
use DB;

use Illuminate\Http\Request;
use larashop\Http\Requests;

class AdminController extends Controller
{
    public function index(User $user)
    {
        $users = $user->all();

        return view('admin.index')->withUsers($users);
    }

    public function products(Product $product)
    {
        $products = $product->all();

        return view('admin.products')->withProducts($products);
    }

    public function getCreate(){

        return view('admin.create');
    }

    public function createProduct(Request $request)
    {
        $this->validate($request, [
            'title' =>  'required|min:4',
            'description'   =>  'required',
            'price' =>  'required',
            'image' =>  'required',
            'stock' =>  'required'
        ]);

        $product = new Product([
            'title' => title_case($request->title),
            'slug' => str_slug($request->title, '-'),
            'description' => $request->description,
            'price' => $request->price,
            'image' =>  $request->image,
            'stock' => $request->stock
        ]);

        if(Product::where('title', $request->title)->first())
        {
            return redirect()->route('admin.create')->with('error', 'Product title already exists');
        }

        $product->save();

        return response()->json($product);
    }

    public function editProduct($product_id)
    {
        $product = Product::find($product_id);

        return response()->json($product);
    }

    public function updateProduct(Request $request, $product_id)
    {
        $product = Product::find($product_id);
        
        $this->validate($request, [
            'title' =>  'required|min:4',
            'description'   =>  'required',
            'price' =>  'required',
            'image' =>  'required',
            'stock' =>  'required'
        ]);

        $product->title = title_case($request->title);
        $product->slug = str_slug($request->title, '-');
        $product->description = $request->description;
        $product->price = $request->price;
        $product->image = $request->image;
        $product->stock = $request->stock;

        $product->save();

        return response()->json($product);
    }

    public function deleteProduct($product_id) {
        $product = Product::find($product_id);

        $order_product = DB::table('order_product')->where('product_id', $product_id);

        $order_product->delete();

        $product->delete();

        return response()->json($product);
    }

    public function postAdminAssignRoles(Request $request)
    {
        $user = User::where('email', $request['email'])->first();

        $user->roles()->detach();

        if($request['role_user']) {
            $user->roles()->attach(Role::where('name', 'user')->first());
        }
        if($request['role_admin']) {
            $user->roles()->attach(Role::where('name', 'administrator')->first());
        }

        return redirect()->back();
    }
}
