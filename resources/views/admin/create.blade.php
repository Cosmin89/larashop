@extends('templates.dashboard')

@section('content')

{!! Form::open(['route' => 'admin.create']) !!}

   @if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
    @endif

   <div class="form-group">
        {!! Form::label('title', 'Title: ', ['class' => 'control-label']) !!}
        {!! Form::text('title', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('slug', 'Slug: ', ['class' => 'control-label']) !!}
        {!! Form::text('slug', null, ['class' => 'form-control']) !!}
    </div>
     <div class="form-group">
        {!! Form::label('description', 'Description: ', ['class' => 'control-label']) !!}
        {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
    </div>
     <div class="form-group">
        {!! Form::label('price', 'Price: ', ['class' => 'control-label']) !!}
        {!! Form::text('price', null, ['class' => 'form-control']) !!}
    </div>
     <div class="form-group">
        {!! Form::label('image', 'Image: ', ['class' => 'control-label']) !!}
        {!! Form::text('image', null, ['class' => 'form-control']) !!}
    </div>
     <div class="form-group">
        {!! Form::label('stock', 'Stock: ', ['class' => 'control-label']) !!}
        {!! Form::text('stock', null, ['class' => 'form-control']) !!}
    </div>

    {!! Form::submit('Create Product', ['class' => 'btn btn-primary']) !!}

    {!! Form::close() !!}
@endsection