@if($product->inStock())
    <p class="label label-success"><span class="glyphicon glyphicon-ok-sign"></span> In stock</p>
@endif 

@if($product->outOfStock())
    <p class="label label-danger"><span class="glyphicon glyphicon-remove-sign"></span> Out of stock </p>
@endif

@if($product->hasLowStock())
    <p class="label label-warning"><span class="glyphicon glyphicon-exclamation-sign"></span> Low stock</p>
@endif