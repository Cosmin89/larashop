<nav class="navbar navbar-default">
  <div class="container-fluid">
      <ul class="nav navbar-nav">
        <li class="{{ (URL::current() == route('admin.index')) ? 'active' : '' }}"><a href="{{ route('admin.index') }}">Dashboard </a></li>
        <li class="{{ (URL::current() == route('admin.products')) ? 'active' : '' }}"><a href="{{ route('admin.products') }}">Products </a></li>
      </ul>


    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
       <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
              <i class="glyphicon glyphicon-user" aria-hidden="true"></i> Admin <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="{{ route('shop.index')}}">Back home</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>