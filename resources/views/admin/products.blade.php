@extends('templates.dashboard')
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading clearfix"><button id="btn_add" name="btn_add" class="btn btn-success pull-right"><span class="glyphicon glyphicon-plus"></span> Create Product</button></div>  
                <div class="panel-body">
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
                        <tbody id="products-list" name="products-list">
                            @foreach($products as $product)
                                <tr id="product{{$product->id}}">
                                    <td>
                                    {{ $product->title }}
                                    </td>
                                    <td><a href="{{ route('product.get', ['slug' => $product->slug]) }}">{{ $product->slug }}</a></td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td><img src="{{ $product->image }}" alt="" class="img-responsive img-square" width="30px" height="30px"></td>
                                    <td>{{ $product->stock }}</td>
                                    <td> 
                                    <button class="btn btn-primary btn-detail open_modal" value="{{$product->id}}"><span class="glyphicon glyphicon-edit"></span> Edit</button>
                                    <button class="btn btn-danger btn-delete delete-product" value="{{$product->id}}">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        @endif
                </table>
            </div>

    </div>
    @include('admin.partials.modal.mymodal')
@endsection

@section('scripts')
    <script>

        var url = "/admin/product";

        //display modal form for product editing
        $(document).on('click', '.open_modal', function(){
            var product_id = $(this).val();

            $.get(url + '/' + product_id, function(data) {
                //success
                console.log(data);
                $('#product_id').val(data.id);
                $('#title').val(data.title);
                $('#slug').val(data.slug);
                $('#description').val(data.description);
                $('#price').val(data.price);
                $('#image').val(data.image);
                $('#stock').val(data.stock);
                $('#btn-save').val("update");

                $('#myModal').modal('show');
            })
        });

        //display modal form from creating new product
        $('#btn_add').click(function() {
            $('#btn-save').val("add");
            $('#frmProducts').trigger("reset");
            $('#myModal').modal('show');
        });

        //delete product and remove it from list
        $(document).on('click', '.delete-product', function() {
            var product_id = $(this).val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })
            $.ajax({
                type: "DELETE",
                url: url + '/' + product_id,
                success: function(data) {
                    console.log(data);

                    $("#product" + product_id).remove();
                },

                error: function(data) {
                    console.log('Error: ', data);
                }
            });
        });

        //create new product / update existing product
        $("#btn-save").click(function (e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })

            e.preventDefault();

            var formData = {
                title: $('#title').val(),
                slug: $('#slug').val(),
                description: $('#description').val(),
                price: $('#price').val(),
                image: $('#image').val(),
                stock: $('#stock').val()
            }

            var state = $('#btn-save').val();

            var type = "POST";
            var product_id = $('#product_id').val();
            var my_url = url;

            if(state == "update") {
                type = "PUT";
                my_url += '/' + product_id;
            }

            console.log(formData);

            $.ajax({
                type: type,
                url: my_url,
                data: formData,
                dataType: 'json',
                success: function(data) {
                    console.log(data);

                    var product = '<tr id="product' + data.id + '"><td>' + data.title + '</td><td><a href="' + data.slug + '">' + data.slug + '</a></td><td>'
                    + data.description + '</td><td>' + data.price + '</td><td><img src="' + data.image + '" alt="" class="img-responsive img-square" width="30px" height="30px"></td><td>' + data.stock + '</td>';
                    product += '<td><button class="btn btn-primary btn-detail open_modal" value="' + data.id + '"><span class="glyphicon glyphicon-edit"></span> Edit</button>';
                    product += ' <button class="btn btn-danger btn-delete delete-product" value="' + data.id + '">Delete</button></td></tr>';

                    if(state == "add"){
                        $('#products-list').append(product);

                    }else {
                        $("#product" + product_id).replaceWith(product);
                    }

                    $('#frmProducts').trigger("reset");

                    $('#myModal').modal('hide')
                },

                error: function(data) {
                    console.log('Error: ', data);
                }
            });
        });

    </script>
@endsection
