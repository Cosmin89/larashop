@extends('templates.app')

@section('content')
    <div class="row">
        <div class="col-md-8">
            @if(Cart::count())
                <div class="well">
                    <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>SubTotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cart as $item)
                            <tr>
                                <td><a href="{{ route('product.get', ['slug' => $item->options->slug]) }}">{{ $item->name }}</a></td>
                                <td>$ {{ $item->price }}</td>
                                <td>
                                    <form action="{{ route('cart.update', ['rowId' => $item->rowId]) }}" method="post" class="form-inline">
                                        <select name="quantity" class="form-control input-sm">
                                            @for($num = 1; $num <= $item->model->stock; $num++)
                                                <option value="{{ $num }}" @if($num == $item->qty) selected="selected" @endif>{{ $num }}</option>
                                            @endfor
                                            <option value="0">None</option>
                                        </select>
                                        <button type="submit" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus"></span></button>
                                    {{ csrf_field() }}
                                    </form>
                                </td>
                                <td> {{ $item->subtotal }} </td>
                                <td><button class="btn btn-default btn-sm" href="{{ route('cart.remove', ['rowId' => $item->rowId]) }}"><span class="glyphicon glyphicon-remove"></span></button></td>
                            </tr>
                        @endforeach
                    </tbody>
                    </table>
                    <div class="clearfix">
                    <hr>
                    <h4 class="pull-left">Total {{ Cart::total() }}</h4>
                    <a href="{{ route('cart.empty') }}" class="btn btn-danger pull-right" role="button"><span class="glyphicon glyphicon-trash"></span> Empty Cart</a>
                    </div>
                </div>
                @else
                <p>You have no items in your cart. <a href="{{ route('shop.index') }}">Start shopping</a></p>
            @endif
        </div>
        <div class="col-md-4">
            @if(Cart::count() && Cart::subtotal())
                <div class="well">
                    <h4>Cart summary</h4>
                    <hr>
                    @include('cart.partials.summary')

                    <a href="{{ route('order.index') }}" class="btn btn-default">Checkout</a>
                </div>
            @endif
        </div>
    </div>
@endsection