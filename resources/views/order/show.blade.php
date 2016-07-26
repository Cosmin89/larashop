@extends('templates.app')

@section('content')
<div class="row">
        <div class="col-md-12">
            <h3>Order # {{ $order->id }}</h3>

            <hr>

            <div class="row">
                <div class="col-md-6">
                    <h4>Shipping to</h4>

                    {{ $order->address->address }} <br>
                    {{ $order->address->city }} <br>
                    {{ $order->address->postal_code }} <br>

                </div>
                <div class="col-md-6">
                    <h4>Items</h4>

                    @foreach($order->products as $product)
                        <a href="{{ route('product.get', ['slug' => $product->slug ]) }}">{{ $product->title }}</a> (x {{ $product->pivot->quantity }}) <br>
                    @endforeach
                </div>
            </div>

            <hr>

            <p>
                <strong>Order total: ${{ $order->amount / 100 }}</strong>
            </p>

        </div>
    </div>
@endsection
