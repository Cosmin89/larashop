<?php

namespace larashop\Http\Controllers;

use Braintree_ClientToken;
use Illuminate\Http\Request;

use larashop\Http\Requests;

class BraintreeTokenController extends Controller
{
    public function token()
    {
        return response()->json([
            'data'  =>  [
                'token' =>  Braintree_ClientToken::generate()
            ]
        ]);
    }
}
