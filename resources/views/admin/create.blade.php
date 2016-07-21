@extends('templates.dashboard')

@section('content')

{!! Form::open(['route' => 'admin.create', 'data-parsley-validate', 'id' => 'product-form']) !!}
   <div class="form-group" id="title">
        {!! Form::label(null, 'Title: ') !!}
        {!! Form::text('title', null, [
                'class' => 'form-control',
                'required'  =>  'required',
                'data-parsley-trigger' => 'change focusout',
                'data-parsley-class-handler'    => '#title'
        ]) !!}
    </div>
    <div class="form-group" id="slug">
        {!! Form::label(null, 'Slug: ') !!}
        {!! Form::text('slug', null, [
                'class' => 'form-control',
                'required'  =>  'required',
                'data-parsley-trigger' => 'change focusout',
                'data-parsley-class-handler'    => '#slug'
        ]) !!}
    </div>
     <div class="form-group" id="description">
        {!! Form::label(null, 'Description: ', ['class' => 'control-label']) !!}
        {!! Form::textarea('description', null, [
                'class' => 'form-control',
                'required'  =>  'required',
                'data-parsley-trigger' => 'change focusout',
                'data-parsley-class-handler'    => '#description'
        ]) !!}
    </div>
     <div class="form-group" id="price">
        {!! Form::label(null, 'Price: ', ['class' => 'control-label']) !!}
        {!! Form::text('price', null, [
                'class' => 'form-control',
                'required'  =>  'required',
                'data-parsley-trigger' => 'change focusout',
                'data-parsley-type'             => 'number',
                'data-parsley-class-handler'    => '#price']) 
        !!}
    </div>
     <div class="form-group" id="image">
        {!! Form::label('image', 'Image: ', ['class' => 'control-label']) !!}
        {!! Form::text('image', null, [
                'class' => 'form-control',
                'required'  =>  'required',
                'data-parsley-trigger' => 'change focusout',
                'data-parsley-class-handler'    => '#image' 
        ]) !!}
    </div>
     <div class="form-group" id="stock">
        {!! Form::label('stock', 'Stock: ', ['class' => 'control-label']) !!}
        {!! Form::text('stock', null, [
                'class' => 'form-control',
                'required'  =>  'required',
                'data-parsley-trigger' => 'change focusout',
                'data-parsley-type'             => 'number',
                'data-parsley-class-handler'    => '#stock'
        ]) !!}
    </div>

    {!! Form::submit('Create Product', ['class' => 'btn btn-primary', 'id' => 'submitBtn']) !!}

    {!! Form::close() !!}
@endsection

@section('scripts')

<script>
        window.ParsleyConfig = {
            errorsWrapper: '<div></div>',
            errorTemplate: '<div class="alert alert-danger parsley" role="alert"></div>',
            errorClass: 'has-error',
            successClass: 'has-success'
        };
    </script>

    <script src="http://parsleyjs.org/dist/parsley.js"></script>

     <script>

        jQuery(function($) {
            $('#product-form').submit(function(event) {
                var $form = $(this);

                $form.parsley().subscribe('parsley:form:validate', function(formInstance) {
                    formInstance.submitEvent.preventDefault();
                    return false;
                });

                $form.find('#submitBtn').prop('disabled', true);

                return false;
            });
        });

@endsection