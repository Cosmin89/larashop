@extends('templates.app')

@section('title')
    {{ $product->title }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            <img src="{{ $product->image }}" alt="{{ $product->title }}" class="thumbnail img-responsive">
        </div>
        <div class="col-md-8">

            @include('templates.partials.availability')

            <h3>{{ $product->title }}</h3>
            <P>{{ $product->description }}</p>

            @if($product->inStock())
                <a href="{{ route('cart.add', ['slug' => $product->slug, 'quantity' => 1]) }}" class="btn btn-default" role="button">Add to Cart</a>
            @endif 
        </div>

        <div class="col-md-6">
        <hr>
            @foreach($product->reviews as $review)
            <div class="panel panel-default">
                <div class="panel-heading">
                   {{ $review->title }}
                </div>
                <div class="panel-body">
                   {{ $review->content }}
                </div>
                <div class="panel-footer clearfix"><i class="pull-right">User: {{ $review->user->name }} | Date: {{ $review->created_at }}</i></div>
            </div>
           @endforeach 

          <hr>
            {!! Form::open(['method' => 'POST', 'route' => ['product.review', $product->id]]) !!}
                <div class="form-group">
                    {!! Form::label('title', 'Title: ', ['class' => 'control-label']) !!}
                    {!! Form::text('title', null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('Content', 'Content: ', ['class' => 'control-label']) !!}
                    {!! Form::textarea('content', null, ['class' => 'form-control']) !!}
                </div>

                {!! Form::submit('Post Review', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection

