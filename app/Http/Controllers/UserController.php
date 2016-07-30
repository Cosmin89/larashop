<?php
namespace larashop\Http\Controllers;

use Illuminate\Http\Request;

use larashop\User;
use larashop\Role;
use larashop\Http\Requests;
use Auth;
use Socialite;
use larashop\Order;

class UserController extends Controller
{
    public function getSignup()
    {
        return view('user.signup');
    }

    public function postSignup(Request $request)
    {
        $role_user = Role::where('name', 'User')->first();

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
        $user->roles()->attach($role_user);

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
            if(Auth::user()->name == "Admin") {
                    return redirect()->action('AdminController@index');
            }

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

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('google')->scopes(['profile', 'email'])->redirect();
    }

     /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleToProviderCallback()
    {
        $role_user = Role::where('name', 'User')->first();

        $user = Socialite::driver('google')->user();
        
        if($authUser = User::where('google_id', $user->id)->first()) {      
            Auth::login($authUser, true);

        } else {
            $authUser = new User([
                'name' =>  $user->name,
                'email'    =>  $user->email,
                'google_id'    =>  $user->id,
                'avatar'   =>  $user->avatar
            ]);

            $authUser->save();
            $authUser->roles()->attach($role_user);
        }

        return redirect()->back();

    }

}