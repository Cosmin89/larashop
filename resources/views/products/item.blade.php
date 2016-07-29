@extends('templates.app')

@section('title')
    {{ $product->title }}
@endsection

@section('content')
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
        
            <h4>Write a review </h4>
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            {!! Form::open(['method' => 'POST', 'route' => ['product.review', $product->id]]) !!}
                <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                    {!! Form::label('title', 'Title: ', ['class' => 'control-label']) !!}
                    {!! Form::text('title', null, ['class' => 'form-control', 'value' => "{{ Input::old('title') }}"]) !!}
                </div>
                <div class="form-group {{ $errors->has('content') ? ' has-error' : '' }}">
                    {!! Form::label('Content', 'Content: ', ['class' => 'control-label']) !!}
                    {!! Form::textarea('content', null, ['class' => 'form-control', 'rows' => 3, 'value' => "{{ Input::old('content') }}"]) !!}
                </div>

                {!! Form::submit('Post Review', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
 
            <hr>

            <div class="col-md-12">
            @foreach($product->reviews as $review)
                <div class="panel panel-default">
                    <div class="panel-heading">
                    {{ $review->title }}
                    </div>
                    <div class="panel-body">
                    <p class="navbar-text">{{ $review->content }} </p>
                    </div>
                    <div class="panel-footer clearfix"><i class="pull-right">User: {{ $review->user->name }} | Date: {{ $review->created_at }}</i></div>
                </div>
                
                    @foreach($review->likes as $user)
                    <p>{{ $user->name }} likes this!</p>
                    @endforeach

                    @if($review->isLiked)
                        <a href="{{ route('review.like', $review->id) }}"><span class="glyphicon glyphicon-thumbs-down"></span> Unlike</a>
                    @else 
                        <a href="{{ route('review.like', $review->id) }}"><span class="glyphicon glyphicon-thumbs-up"></span> Like</a>
                    @endif

                    <span class="badge">{{ $review->likes()->count() }}</span>

                    <hr>
            @endforeach 
        </div>
        </div>
@endsection

