<?php
namespace larashop\Http\Controllers;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;

use larashop\User;
use larashop\Http\Requests;
use Auth;
use Cart;
use larashop\Order;
use larashop\Product;
use larashop\Address;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Customer;

class OrderController extends Controller
{

    public function index()
    {
        if(!Cart::count()){
            return redirect()->route('cart.index');
        }

        return view('order.index');
    }

    public function display()
    {
        $user = User::where('id', Auth::user()->id)->first();

        $orders = $user->orders;

        return view('user.orders.display', ['orders' => $orders]);
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
        
        $token = $request->input('stripeToken');

        $address = Address::firstOrCreate([
            'address'  => $request->input('address'),
            'city' => $request->input('city'),
            'postal_code' => $request->input('postal_code')
        ]);

        Stripe::setApiKey(env('STRIPE_SK'));

        $cart = Cart::content();

        if(Auth::check()) {
            try {
                $customer = Customer::create([
                    'source' => $token,
                    'email' =>  Auth::user()->email,
                    'metadata'  =>  [
                        "name"    =>  Auth::user()->name,
                    ]
                ]);
            } catch(\Stripe\Error\Card $e) {
                return redirect()->route('order')
                    ->withErrors($e->getMessage())
                    ->withInput();
            }

            $customerID = $customer->id;

            if(!Auth::user()->stripe_customer_id) {
                 $user = User::where('email', Auth::user()->email)->update(['stripe_customer_id' => $customerID]);
            }
        } else {
            $customerID = User::where('email', $email)->value('stripe_customer_id');
            $user = User::where('email', $email)->first();
        }
        try {
            foreach($cart as $item) {
                    $charge = Charge::create([
                        'amount'    =>  Cart::total() * 100,
                        'currency'  =>  'usd',
                        'customer'  =>  $customerID,
                        'metadata'  =>  [
                            'product_name'  => $item->name,
                            'product_price' =>  $item->price
                        ]
                    ]);
            }
            
             $order = new Order();

             $order->amount = Cart::total();
             $order->address_id = $address->id;
             $order->payment_id = $charge->id;
           
             Auth::user()->orders()->save($order);
        
        } catch (\Stripe\Error\Card $e) {
            return redirect()->route('order')
                ->withErrors($e->getMessage())
                ->withInput();
        }

       
        foreach($cart as $item) {
            $order->products()->attach($item->id, ['quantity' => $item->qty]);

            $product = Product::where('id', $item->id);
            
            $product->decrement('stock', $item->qty);
        }     
        
        Cart::destroy();

        return redirect()->route('shop.index')
            ->with('successful', 'Your purchase was successful!');
    }
    
}