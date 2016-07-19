<?php
namespace larashop\Http\Controllers;

use Illuminate\Http\Request;

use larashop\User;
use larashop\Http\Requests;
use Auth;
use DB;
use larashop\Order;

class UserController extends Controller
{
    public function getSignup()
    {
        return view('user.signup');
    }

    public function postSignup(Request $request)
    {
        $this->validate($request, [
            'name'  =>  'required|min:4',
            'email' => 'email|required|unique:users',
            'password' => 'required|min:4'
        ]);

        $user = new User([
            'name'  => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password'))
        ]);

        $user->save();

        Auth::login($user);
        return redirect()->back();
    }

    public function getSignin()
    {
        return view('user.signin');
    }

    public function postSignin(Request $request)
    {
        $this->validate($request, [
            'email' => 'email|required',
            'password' => 'required|min:4'
        ]);

        if(Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')]))
        {
            return redirect()->action('UserController@getProfile', ['name' => Auth::user()->name]);
        }

        return redirect()->back();
    }

    public function getProfile($name)
    {
        $user = User::find(Auth::user()->id);

        return view('user.profile')->with('user', $user);
    }

    public function getLogout()
    {
        Auth::logout();

        return redirect()->back();
    }

    public function postReview()
    {
        
    }
}