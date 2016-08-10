<form class="navbar-form navbar-left" role="search" method="POST" action="{{ route('search') }}">
          {{ csrf_field() }}
          <div class="form-group">
            <input type="text" class="form-control" name="search" placeholder="Search">
          </div>
          <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
</form>