<?php

namespace larashop\Http\Controllers;

use Auth;
use Socialite;
use Session;

use larashop\User;
use larashop\Role;
use larashop\Social;
use larashop\Order;
use ReCaptcha\ReCaptcha;

use Illuminate\Http\Request;
use larashop\Http\Requests;

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
            'password' => 'required|min:4',
            'g-recaptcha-response' => 'required'
        ]);

        if($this->captchaCheck($request) == false)
        {
            return redirect()->back();
        }

        $user = new User([
            'name'  => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password'))
        ]);

        $user->save();

        $role = Role::whereName('user')->first();
        $user->assignRole($role);

        Auth::login($user);

        return redirect()->route('user.profile', ['name' => $request->user()->name]);
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

            if($request->user()->hasRole('user'))
            {
                return redirect()->route('user.profile', ['name' => Auth::user()->name]);
            }

            if($request->user()->hasRole('administrator'))
            {
                return redirect()->route('admin.index');
            }

            return redirect()->route('user.profile', ['name' => Auth::user()->name]);
        }

        return redirect()->back();
    }

    public function getProfile(User $user)
    {
        return view('user.profile')->withUser($user);
    }

    public function getLogout()
    {
        Auth::logout();

        return redirect()->route('user.signin');
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

    private function captchaCheck(Request $request)
    {
        $response = $request->input('g-recaptcha-response');
        $remoteip = $_SERVER['REMOTE_ADDR'];
        $secret   = env('RE_CAP_SECRET');

        $recaptcha = new ReCaptcha($secret);
        $resp = $recaptcha->verify($response, $remoteip);
        if($resp->isSuccess()) {
            return true;
        } else {
            return false;
        }
    }
}
