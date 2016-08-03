@extends('templates.dashboard')
@section('content')
     @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="panel panel-default">
        <div class="panel-heading clearfix"><a href="#" class="btn btn-success pull-right" data-toggle="modal" data-target="#create-modal"><span class="glyphicon glyphicon-plus"></span> Create Product</a></div>  
                <table class="table table-hover">
                @if(count($products) != 0 )
                     <thead>
                        <tr>
                            <th>Title</th>
                            <th>Slug</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Image</th>
                            <th>Stock</th>
                            <th></th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>
                                   {{ $product->title }}
                                </td>
                                <td><a href="{{ route('product.get', ['slug' => $product->slug]) }}">{{ $product->slug }}</a></td>
                                <td>{{ $product->description }}</td>
                                <td>{{ $product->price }}</td>
                                <td><img src="{{ $product->image }}" alt="" class="img-responsive img-square" width="30px" height="30px"></td>
                                <td>{{ $product->stock }}</td>
                                {!! Form::open(['method' =>  'DELETE', 'route'  =>  ['admin.delete', $product->id]]) !!}
                                <td> 
                                    <a href="{{ route('admin.edit', ['id' => $product->id]) }}" class="btn btn-primary" ><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                                    <button type="submit" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</button>
                                </td>
                                {!! Form::close() !!} 
                            </tr>
                        @endforeach
                     </tbody>
                     @endif
                </table>
    </div>
    @include('admin.partials.modal.create')
@endsection

@section('scripts')
    <script>
        var token = '{{ Session::token() }}';

        $('#modal-create').on('click', function () { 
            $.ajax({ 
                method: 'POST', 
                url: '{{ route('admin.create') }}', 
                data: {
                title: $('#title').val(),
                slug: $('#slug').val(),
                description: $('#description').val(),
                price: $('#price').val(),
                image: $('#image').val(),
                stock:$('#stock').val(),
                _token: token
                }          
            }).done(function(msg) {
                $('#create-modal').modal('hide');
            });
        });

    </script>
@endsection
