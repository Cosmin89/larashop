<?php

namespace larashop\Http\Controllers;

use larashop\Product;
use larashop\Review;

use Cart;
use Auth;

use Illuminate\Http\Request;
use larashop\Http\Requests;

class ProductController extends Controller
{
    public function getProduct(Product $product)
    {
        return view('products.item')->withProduct($product);
    }

    public function cartIndex()
    {
        $cart = Cart::content();
        
        return view('cart.index', ['cart' => $cart]);
    }

    public function addToCart($slug, $quantity) {
        $product = Product::where('slug', $slug)->first();

        $cartItem = Cart::add([
            'id' => $product->id,
            'name' => $product->title,
            'qty' => $quantity,
            'price' => $product->price,
            'options' => [
                'image' => $product->image,
                'slug'  => $product->slug
            ],
        ]);

        Cart::associate($cartItem->rowId, '\larashop\Product');

        return redirect()->back();
    }

    public function updateCart($rowId, Request $request)
    {
        Cart::update($rowId, $request->input('quantity'));

        return redirect()->route('cart.index');   
    }

    public function emptyCart()
    {
        Cart::destroy();

        return redirect()->route('cart.index');
    }

    public function removeItem($rowId)
    {
        Cart::remove($rowId);

        return redirect()->route('cart.index');
    }

    public function postReview($id, Request $request)
    {
        $this->validate($request, [
            'title' =>  'required|min:5',
            'content'   =>  'required|max:100'
        ]);

        $product = Product::find($id);

        $product->reviews()->create([
            'title' =>  $request->input('title'),
            'content'   =>  $request->input('content'),
            'product_id'    =>  $product->id,
            'user_id'   =>  $request->user()->id
        ]);

        return redirect()->back();
    }
}
