<div class="col-md-8 col-md-offset-2">
<div class="modal fade" tabindex="-1" role="dialog" id="myModal" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header"> 
        @foreach(Cart::content() as $item)
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">{{ $item->name }}</h4>
      </div>
        <div class="modal-body"> 
                    <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Image</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td><img src="{{ $item->model->image }}" alt="" class="img-responsive" width="30px" height="30px"></td>
                                <td>$ {{ $item->price }}</td>
                            </tr>
                        
                    </tbody>
                    </table>
                </div>
        </div>
        @endforeach
        <div class="modal-footer">
          <button type="button" href="{{ route('cart.index') }}" class="btn btn-primary" id="cart" value="">View Cart</button>
          <input type="hidden" id="product_id" name="product_id" value="0">
        </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
<meta name="_token" content="{{ csrf_token() }}" />
