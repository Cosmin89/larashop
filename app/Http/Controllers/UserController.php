<?php
namespace larashop\Http\Controllers;

use Illuminate\Http\Request;

use larashop\User;
use larashop\Role;
use larashop\Http\Requests;
use Auth;
use Socialite;
use larashop\Social;
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

        $role = Role::whereName('user')->first();
        $user->assignRole($role);

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

            if(Auth::user()->hasRole('user'))
            {
                return redirect()->route('user.profile', ['name' => Auth::user()->name]);
            }

            if(Auth::user()->hasRole('administrator'))
            {
                return redirect()->route('admin.index');
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

   public function getSocialRedirect($provider)
   {
       $providerKey = \Config::get('services.' . $provider);
       if(empty($providerKey))
                return view('pages.status')
                        ->with('error', 'No such provider');

        return Socialite::driver($provider)->redirect();
   }

   public function getSocialHandle($provider)
   {
       $user = Socialite::driver($provider)->user();

       $socialUser = null;

       $userCheck = User::where('email', $user->email)->first();
       if(!empty($userCheck))
       {
           $socialUser = $userCheck;
       }
       else
       {
           $sameSocialId = Social::where('social_id', $user->id)->where('provider', $provider)->first();

           if(empty($sameSocialId))
           {
               $newSocialUser = new User();
               $newSocialUser->email = $user->email;
               $newSocialUser->name = $user->name;
               $newSocialUser->save();

               $socialData = new Social();
               $socialData->social_id = $user->id;
               $socialData->provider = $provider;
               $socialData->avatar = $user->avatar;
               $newSocialUser->socials()->save($socialData);

               $role = Role::whereName('user')->first();
               $newSocialUser->assignRole($role);

               $socialUser = $newSocialUser;
           }
           else
           {
               $socialUser = $sameSocialId->user;
           }
       }

       Auth::login($socialUser, true);

       if(Auth::user()->hasRole('user'))
       {
           return redirect()->route('user.profile', ['name' => Auth::user()->name]);
       }

       if(Auth::user()->hasRole('administrator'))
       {
           return redirect()->route('admin.index');
       }

       return abort(500);
   }

}