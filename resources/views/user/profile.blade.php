@extends('templates.app')

@section('content')
            <img src="{{ Auth::user()->avatar }}" alt="" class="img-circle"/>
            <h3> My Orders </h3>

            @foreach($user->orders as $order)
                    <p><a href="{{ route('order.show', ['stripe_transaction_id' => $order->stripe_transaction_id]) }}">{{ $order->stripe_transaction_id }}</a></p>
            @endforeach

            <hr>

            <h3> My Reviews <h3>

            @foreach($user->reviews as $review)
                <h4><a href="{{ route('product.get', ['slug' => $review->product->slug]) }}">{{ $review->title }}</a> </h4> Date {{ $review->created_at }} 
                <article>
                        {{ $review->content }} 
                </article> 

            @endforeach

            <hr>

            <h3>My Likes: {{ $user->likedReviews->count() }}</h3> 
            @foreach($user->likedReviews as $review)
                <h5><a href="{{ route('product.get', ['slug' => $review->product->slug]) }}">{{ $review->title }}</a></h5>
            @endforeach
@endsection