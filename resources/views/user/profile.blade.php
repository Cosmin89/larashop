@extends('templates.app')

@section('content')

<div class="row">
        <div class="col-md-12">
            <h3> My Orders </h3>
            <hr>

            @foreach($user->orders as $order)
                    <p><a href="{{ route('order.show', ['stripe_transaction_id' => $order->stripe_transaction_id]) }}">{{ $order->stripe_transaction_id }}</a></p>
            @endforeach

            <h3> My Reviews <h3>
            <hr>

            @foreach($user->reviews as $review)
                <h4><a href="{{ route('product.get', ['slug' => $review->product->slug]) }}">{{ $review->title }}</a> </h4> Date {{ $review->created_at }}
                <article>
                        {{ $review->content }}
                </article>
            @endforeach
        </div>
</div>
@endsection