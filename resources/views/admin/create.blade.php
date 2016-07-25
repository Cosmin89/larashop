@extends('templates.dashboard')

@section('content')
@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
{!! Form::open(['route' => 'admin.create']) !!}
   <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
        {!! Form::label(null, 'Title: ') !!}
        {!! Form::text('title', null, ['class' => 'form-control', 'value' => "{{ Input::old('title') }}"]) !!}
    </div>
    <div class="form-group {{ $errors->has('slug') ? ' has-error' : '' }}">
        {!! Form::label(null, 'Slug: ') !!}
        {!! Form::text('slug', null, ['class' => 'form-control', 'value' => "{{ Input::old('slug') }}"]) !!}
    </div>
     <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
        {!! Form::label(null, 'Description: ', ['class' => 'control-label']) !!}
        {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 3, 'value' => "{{ Input::old('description') }}"]) !!}
    </div>
     <div class="form-group {{ $errors->has('price') ? ' has-error' : '' }}">
        {!! Form::label(null, 'Price: ', ['class' => 'control-label']) !!}
        {!! Form::text('price', null, ['class' => 'form-control', 'value' => "{{ Input::old('price') }}"]) 
        !!}
    </div>
     <div class="form-group {{ $errors->has('image') ? ' has-error' : '' }}">
        {!! Form::label('image', 'Image: ', ['class' => 'control-label']) !!}
        {!! Form::text('image', null, ['class' => 'form-control', 'value' => "{{ Input::old('image') }}"]) !!}
    </div>
     <div class="form-group {{ $errors->has('stock') ? ' has-error' : '' }}">
        {!! Form::label('stock', 'Stock: ', ['class' => 'control-label']) !!}
        {!! Form::text('stock', null, ['class' => 'form-control', 'value' => "{{ Input::old('stock') }}"]) !!}
    </div>

    {!! Form::submit('Create Product', ['class' => 'btn btn-primary']) !!}

    {!! Form::close() !!}
@endsection