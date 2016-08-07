@extends('templates.app')

@section('content')

@include('user.partials.nav')
        <div class="col-md-8 col-md-offset-2">
            <div class="row">   
                <h3>My Orders</h3>
                @foreach($orders as $order)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        # <a href="{{ route('order.show', ['payment_id' => $order->payment_id]) }}">{{ $order->payment_id }}</a>
                    </div>
                    <div class="panel-body">
                            <table class="table table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            @foreach($order->products as $product)
                            <tbody>
                                    <tr>
                                        <td>{{ $product->title }}</td>
                                        <td>{{ $product->pivot->quantity }}</td>
                                        <td>{{ $product->price }}</td>
                                    </tr>
                            </tbody>
                            @endforeach
                        </table>
                    </div>
                    <div class="panel-footer">
                        <strong>Total: ${{ $order->amount }}</strong>
                    </div>
                </div>
                @endforeach
            </div>
        </div>   
@endsection
