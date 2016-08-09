@extends('templates.dashboard')

@section('content')
     <div class="panel panel-default">
        <div class="panel-heading clearfix"><strong>Users panel</strong></div>
            <div class="panel-body">
                <table class="table table-hover">
                     <thead>
                        <tr>
                            <th>Name</th>
                            <th>E-mail</th>
                            <th>Stripe Customer ID</th>
                            <th>User</th>
                            <th>Admin</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($users as $user)
                            <tr>
                            {!! Form::open(['method' => 'POST', 'route' => ['admin.assign']]) !!}
                                <td>
                                   {{ $user->name }}
                                </td>
                                <td>{{ $user->email }} <input type="hidden" name="email" value="{{ $user->email }}"></td>
                                <td>{{ $user->stripe_customer_id }}</td>
                                <td><input type="checkbox"{{ $user->hasRole('User') ? 'checked' : '' }} name="role_user"></td>
                                <td><input type="checkbox"{{ $user->hasRole('Admin') ? 'checked' : '' }} name="role_admin"></td>
                                <td><button type="submit" class="btn btn-primary btn-sm">Assign Roles</button></td>
                            {!! Form::close() !!}
                            </tr>
                        @endforeach
                     </tbody>
                </table>
            </div>
    </div>
    
@endsection