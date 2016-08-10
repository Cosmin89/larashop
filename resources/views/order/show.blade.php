@extends('templates.app')

@section('content')

        <h3>Order # {{ $order->payment_id }}</h3>

        <hr>
        <div class="row">
            <div class="col-md-6">
                <h4>Billing Address</h4>

                {{ $order->address->address }} <br>
                {{ $order->address->city }} <br>
                {{ $order->address->postal_code }} <br>

                <h4>Payment method</h4>
                {{ $charge->source->brand }} | Last 4 digits: {{ $charge->source->last4 }}
                
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
            <strong>Order total: ${{ $order->amount }}</strong>
        </p>
@endsection
