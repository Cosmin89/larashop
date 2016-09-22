@extends('templates.app')

@section('content')

<div class="col-md-8 col-md-offset-2">
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#orders">Orders</a></li>
        <li><a data-toggle="tab" href="#address">Addresses</a></li>
        <li><a data-toggle="tab" href="#reviews">Reviews</a></li>
        <li><a data-toggle="tab" href="#likes">Likes</a></li>
    </ul>

    <div class="tab-content">
        <div id="orders" class="tab-pane fade in active">
        <h3>My Orders</h3>
            <div class="panel-group">
                @foreach($user->orders as $order)
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
        <div id="address" class="tab-pane fade">
             <h3>My Addresses</h3>
             @foreach($user->addresses as $address)
                  {{ $address->address }} <br>
                  {{ $address->city }} <br>
                  {{ $address->postal_code }} <br>
                  <hr>
             @endforeach
        </div>
        <div id="reviews" class="tab-pane fade">
        <h3>My Reviews</h3>
            @foreach($user->reviews as $review)
                    <h4><a href="{{ route('product.get', ['slug' => $review->product->slug]) }}">{{ $review->title }}</a> </h4> Date {{ $review->created_at }} 
                    <article>
                            {{ $review->content }} 
                    </article> 

            @endforeach
            <hr>
        </div>
        <div id="likes" class="tab-pane fade">
            <h3>My Likes: {{ $user->likedReviews->count() }}</h3> 
                @foreach($user->likedReviews as $review)
                    <h5><a href="{{ route('product.get', ['slug' => $review->product->slug]) }}">{{ $review->title }}</a></h5>
                @endforeach
        </div>
    </div>
</div>

@endsection