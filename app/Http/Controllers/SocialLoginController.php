<?php

namespace larashop\Http\Controllers;

use Auth;
use larashop\User;
use larashop\Role;
use larashop\Social;
use Socialite;

use Braintree_Customer;
use Illuminate\Http\Request;

use larashop\Http\Requests;
use larashop\Http\Controllers\Controller;

class SocialLoginController extends Controller
{
    public function __construct()
    {   
        $this->middleware(['social', 'guest']);
    }

    public function redirect($service, Request $request)
    {
        return Socialite::driver($service)->redirect();
    }

    public function callback($service, Request $request)
    {
        $serviceUser = Socialite::driver($service)->user();

        $user = $this->getExistingUser($serviceUser, $service);

        if(!$user) {
            
            $user = User::create([
                'name'  =>  $serviceUser->getName(),
                'email' =>  $serviceUser->getEmail(),
            ]);

            $role = Role::whereName('user')->first();
            $user->assignRole($role);

        }

        if($this->needsToCreateSocial($user, $service)) {
            $user->social()->create([
                'social_id' =>  $serviceUser->getId(),
                'service'   =>  $service,
                'avatar'    =>  $user->getAvatarUrl()
            ]);
        }

        Auth::login($user, false);

        if(Auth::user()->hasRole('user'))
        {
            return redirect()->route('user.profile', ['name' => Auth::user()->name]);
        }

        if(Auth::user()->hasRole('administrator'))
        {
            return redirect()->route('admin.index');
        }

    }

    protected function needsToCreateSocial(User $user, $service) 
    {
        return !$user->hasSocialLinked($service);
    }

    protected function getExistingUser($serviceUser, $service)
    {
        return User::where('email', $serviceUser->getEmail())
                ->orWhereHas('social', function($q) use ($serviceUser, $service) {
                    $q->where('social_id', $serviceUser->getId())->where('service', $service);
                })->first();
    }
}
