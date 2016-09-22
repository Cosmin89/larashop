@extends('templates.app')

@section('title')
    Larashop
@endsection

@section('content')
        @foreach($products->chunk(4) as $row)
            <div class="row">
            @foreach($row as $product)
                <div class="col-md-3">
                    <div class="thumbnail">
                        <img src="{{ $product->image }}" alt="{{ $product->title }}" class="img-responsive" height="150" width="150"></a>
                        <div class="caption">
                            @include('templates.partials.availability') 
                            <h5>
                                <a href="{{ route('product.get', ['slug' => $product->slug]) }}">{{ $product->title }}</a>    
                            </h5>
                            
                            <p>{{ $product->description }}</p>
                            <div class="clearfix">
                                <h4 class="pull-left">{{ $product->price }} $ </h4>
                                <a href="{{ route('cart.add', ['slug' => $product->slug, 'quantity' => 1]) }}" class="btn btn-primary pull-right" role="button">Add to Cart</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
        @endforeach
@endsection