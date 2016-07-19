@extends('templates.dashboard')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading clearfix"><a href="{{ route('admin.create') }}" class="btn btn-success pull-right">Create Product</a></div>
            <div class="table-responsive">   
                <table class="table table-hover">
                     <thead>
                        <tr>
                            <th>Title</th>
                            <th>Slug</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Image</th>
                            <th>Stock</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>
                                   {{ $product->title }}
                                </td>
                                <td>{{ $product->slug }}</td>
                                <td>{{ $product->description }}</td>
                                <td>{{ $product->price }}</td>
                                <td>{{ $product->image }}</td>
                                <td>{{ $product->stock }}</td>
                                <td> <a href="{{ route('admin.edit', ['id' => $product->id]) }}" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> Edit</a><td>
                                <td> {!! Form::open(['method' =>  'DELETE', 'route'  =>  ['admin.delete', $product->id]]) !!}
                                     {!! Form::submit('Delete', array('class' => 'btn btn-danger')) !!}
                                     {!! Form::close() !!}  </td>
                            </tr>
                        @endforeach
                     </tbody>
                </table>
            </div>
    </div>
@endsection