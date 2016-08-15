<nav class="navbar navbar-default">
  <div class="container-fluid">

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="{{ (URL::current() == route('shop.index')) ? 'active' : '' }}"><a href="{{ route('shop.index') }}">Home </a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li>
            <a href="{{ route('cart.index') }}">
                <i class="fa fa-shopping-cart" aria-hidden="true"></i> Cart
                <span class="badge" data-placement="bottom" data-toggle="tooltip" title="@foreach(Cart::content() as $item) {{ $item->name }} @endforeach">{{ Cart::count() }}</span>
            </a>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
              <i class="glyphicon glyphicon-user" aria-hidden="true"></i> User Management <span class="caret"></span></a>
          <ul class="dropdown-menu">
            @if(Auth::check())
              @if(Auth::user()->hasRole('Admin'))
                <li><a href="{{ route('admin.index') }}">Dashboard</a></li>
              @else
                <li><a href="{{ route('user.profile', ['name' => Auth::user()->name]) }}"><img src="@foreach(Auth::user()->socials as $social) {{ $social->avatar }} @endforeach" height="25" width="25" alt="" class="img-circle"/> User Profile</a> </li>
              @endif
              <li role="separator" class="divider"></li>
              <li><a href="{{ route('user.logout') }}"><i class="glyphicon glyphicon-log-out"></i> Logout</a></li>
            @else
              <li><a href="{{ route('user.signup') }}">Signup</a></li>
              <li><a href="{{ route('user.signin') }}"><i class="fa fa-sign-in" aria-hidden="true"></i> Signin</a></li>
              <li><a href="{{ route('social.redirect', ['provider' => 'google']) }}"><i class="fa fa-google" aria-hidden="true"></i> Signin with Google</a></li>
              <li><a href="{{ route('social.redirect', ['provider' => 'github']) }}"><i class="fa fa-github" aria-hidden="true"></i> Signin with Github</a></li>
            @endif
          </ul>
        </li>
      </ul>
        @include('templates.partials.search')
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
@section('scripts')

<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();   
    });
</script>

@endsection
