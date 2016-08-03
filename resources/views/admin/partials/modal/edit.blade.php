<div class="modal fade" tabindex="-1" role="dialog" id="edit-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Product</h4>
      </div>
      {!! Form::model($product, [
       'method' =>  'PUT',
       'route'  =>  ['admin.update', $product->id]]) !!}
      <div class="modal-body">
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
          </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="modal-save">Save changes</button>
      </div>
       {!! Form::close() !!}
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
