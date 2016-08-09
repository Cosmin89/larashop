@extends('templates.app')

@section('title')
    {{ $product->title }}
@endsection

@section('content')
        <div class="col-md-4">
            <img src="{{ $product->image }}" alt="{{ $product->title }}" class="thumbnail img-responsive">
        </div>
        <div class="col-md-8" style="margin-bottom: 10px">
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

            <div class="col-md-12" style="margin-top:10px">
            <hr>

                @foreach($product->reviews as $review)
                
                <ul class="media-list">
                    <li class="media">
                        <div class="media-left">
                            <img class="media-object img-circle" src="{{ $review->user->avatar }}" alt="...">
                        </div>
                       
                        <div class="media-body">
                            <h4 class="media-heading">{{ $review->title }}</h4>
                            by {{ $review->user->name }} on {{ $review->created_at->format('Y-m-d') }}
                             
                            <div class="panel-body">
                               {{ $review->content }}
                            </div>
                                <i data-toggle="tooltip" data-placement="top" data-title=" Liked by: @foreach($review->likes as $user) {{ $user->name }} @endforeach" class="fa fa-thumbs-up" aria-hidden="true"></i>
                            
                            @if($review->isLiked)
                                <a href="{{ route('review.like', $review->id) }}"> Unlike</a>
                            @else 
                                <a href="{{ route('review.like', $review->id) }}"> Like</a>
                            @endif
                            <span class="badge">{{ $review->likes()->count() }}</span>
                        </div>
                    </li>
                </ul>
                @endforeach
            </div>
@endsection
@section('scripts')

<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();   
    });
</script>

@endsection

