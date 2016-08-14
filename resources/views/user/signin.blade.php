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
            <button type="submit" class="btn btn-primary"><i class="fa fa-sign-in" aria-hidden="true"></i> Sign In</button>
            <a href="{{ route('social.redirect', ['provider' => 'google'])  }}" class="btn btn-danger"><i class="fa fa-google" aria-hidden="true"></i> Signin with Google</a>
            {{ csrf_field() }}
        </form>

        <p>Don't have an account ? <a href="{{ route('user.signup') }}">Sign Up</a>               
    </div>
@endsection

