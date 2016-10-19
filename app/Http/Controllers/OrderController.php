<?php

namespace larashop\Http\Controllers;

use larashop\User;
use larashop\Order;
use larashop\Product;
use larashop\Address;

use Braintree_Transaction;
use Braintree_PaymentMethod;
use Braintree_Customer;

use Auth;
use Cart;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use larashop\Http\Requests;

class OrderController extends Controller
{
    public function index()
    {

        if(!Cart::count()){
            return redirect()->route('cart.index');
        }

        return view('order.index');

    }

    public function show($payment_id)
    {

        $order = Order::with(['address', 'products'])->where('payment_id', $payment_id)->first();
        
        return view('order.show', ['order' => $order]);
    }

    public function postOrder(Request $request)
    {
        if(!Cart::subtotal()) {
            return view('cart.index');
        }

        if($request->input('addressId')){
            $address = Address::where('id', $request->input('addressId'))->first();
        }else {
            $address = Address::firstOrCreate([
                'address'  => $request->input('address'),
                'city'      =>  $request->input('city'),
                'postal_code'   =>  $request->input('postal_code'),
                'user_id'   => $request->user()->id
            ]);
        }

        $cart = Cart::content();

        foreach($cart as $item) {
                $result = Braintree_Transaction::sale([
                    'customerId'    => $this->createCustomer($request),
                    'amount'    =>  Cart::total(),
                    'options' => [
                        'submitForSettlement' => True
                    ]
                ]);
        }   

        $order = new Order();

        $order->amount = Cart::total();
        $order->address_id = $address->id;
        $order->payment_id = $result->transaction->id;
    
        $request->user()->orders()->save($order);

        foreach($cart as $item) {
            $order->products()->attach($item->id, ['quantity' => $item->qty]);

            $product = Product::where('id', $item->id);
            
            $product->decrement('stock', $item->qty);
        }     
        
        Cart::destroy();

        return redirect()->route('shop.index')
            ->with('successful', 'Your purchase was successful!');
    }

    protected function createCustomer(Request $request)
    {
        if(!$request->user()->customerId)
        {
            $result = Braintree_Customer::create([
                'firstName' =>  $request->user()->name,
                'email'     =>  $request->user()->email,
                'paymentMethodNonce'    =>  $request->input('payment_method_nonce'),
                'creditCard'    =>  [
                    'billingAddress'    => [
                        'firstName' =>  $request->user()->name,
                        'streetAddress'   => $request->input('address'),
                        'locality'    =>  $request->input('city'),
                        'postalCode'    =>  $request->input('postal_code'),
                    ]
                ]
            ]);

            if($result->success)
            {   
                foreach($result->customer->paymentMethods as $payment) {
                    User::where('email', $request->user()->email)->update(['customerId' => $result->customer->id, 'cardType' => $payment->cardType, 'last4' => $payment->last4]);
                }
                    
                return $result->customer->id;
            } else {
                foreach($result->errors->deepAll() as $error)
                {
                    return $error->message;
                }
            }
        }else {
            return $request->user()->customerId;
        }
    
    }
}
