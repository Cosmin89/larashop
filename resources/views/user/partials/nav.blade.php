
<ul class="nav nav-tabs">
        <li role="presentation" class="{{ (URL::current() == route('orders.display')) ? 'active' : ''}}"><a href="{{ route('orders.display')}}">Orders</a></li>
        <li role="presentation"><a href="#">Addresses</a></li>
        <li role="presentation"><a href="#">Reviews</a></li>
</ul>

