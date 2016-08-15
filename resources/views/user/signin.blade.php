@extends('templates.app')

@section('content')
    <div class="col-md-4 col-md-offset-4">
        <h1>Sign In</h1>
        @if(count($errors) > 0)
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
        <form action="{{ route('user.signin') }}" method="post">
            <div class="form-group">
                <label for="email">E-Mail</label>
                <input type="text" id="email" name="email" class="form-control">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control">
            </div>
            <ul class="list-group">
                <li class="list-group-item"><button type="submit" class="btn btn-primary"><i class="fa fa-sign-in" aria-hidden="true"></i> Sign In</button></li>
                <li class="list-group-item"><a href="{{ route('social.redirect', ['provider' => 'google'])  }}" class="btn btn-danger"><i class="fa fa-google" aria-hidden="true"></i> Signin with Google</a></li>
                <li class="list-group-item"><a href="{{ route('social.redirect', ['provider' => 'github'])  }}" class="btn btn-default"><i class="fa fa-github" aria-hidden="true"></i> Signin with Github</a></li>
            </ul>
            {{ csrf_field() }}
        </form>

        <p>Don't have an account ? <a href="{{ route('user.signup') }}">Sign Up</a>               
    </div>
@endsection

