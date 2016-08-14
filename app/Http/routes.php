<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', [
    'uses'  =>  'HomeController@index',
    'as'    =>  'shop.index'
]);

Route::get('/product/{slug}', [
    'uses'  => 'ProductController@getProduct',
    'as'    => 'product.get'
]);


Route::any('/search', [
    'uses'  =>  'HomeController@search',
    'as'    =>  'search'
]);

Route::group(['prefix' => 'user'], function() {
    Route::group(['middleware' => 'guest'], function() {
        Route::get('/signup', [
            'uses' => 'UserController@getSignup',
            'as'   => 'user.signup' 
        ]);

        Route::post('/signup', [
            'uses' => 'UserController@postSignup',
            'as'   => 'user.signup' 
        ]);

        Route::get('/signin', [
            'uses' => 'UserController@getSignin',
            'as'   => 'user.signin', 
        ]);

        Route::post('/signin', [
            'uses' => 'UserController@postSignin',
            'as'   => 'user.signin' 
        ]);

        Route::get('/social/redirect/{provider}', [
            'uses'  =>  'UserController@getSocialRedirect',
            'as'    =>  'social.redirect'
        ]);

        Route::get('/social/handle/{provider}', [
            'uses'  =>  'UserController@getSocialHandle',
            'as'    =>  'social.handle'
        ]);
    });

    Route::group(['middleware' => 'auth'], function() {
        Route::group(['middleware' => 'roles', 'roles' => ['user', 'administrator']], function(){
            Route::get('/{name}/profile', [
                'uses'  => 'UserController@getProfile',
                'as'    => 'user.profile' 
            ]);

            Route::get('/logout', [
                'uses'  =>  'UserController@getLogout',
                'as'    =>  'user.logout'
            ]);

            Route::get('/order', [
                'uses'  =>  'OrderController@index',
                'as'    =>  'order.index'
            ]);

            Route::post('/order', [
                'uses'  =>  'OrderController@postOrder',
                'as'    =>  'order.post'
            ]);

            Route::get('order/{payment_id}', [
                'uses'  =>  'OrderController@show',
                'as'    =>  'order.show'
            ]);

            Route::post('review/{id}', [
                'uses'  =>  'ProductController@postReview',
                'as'    =>  'product.review'
            ]);

            Route::get('review/like/{id}', [
                'uses'  =>  'LikeController@likeReview',
                'as'    =>  'review.like'
            ]);
        });
    });
});

Route::group(['prefix' => 'admin'], function() {
    Route::group(['middleware' => 'auth'], function() {
        Route::group(['middleware' => 'roles', 'roles' => ['administrator']], function() {
            Route::get('/dashboard', [
                'uses'  =>  'AdminController@index',
                'as'    =>  'admin.index'
            ]);

            Route::get('/products', [
                'uses'  =>  'AdminController@products',
                'as'    =>  'admin.products'
            ]);

            Route::get('/product', [
                    'uses'  =>  'AdminController@getCreate',
                    'as'    =>  'admin.create'
            ]);

            Route::post('/product', [
                'uses'  =>  'AdminController@postCreate',
                'as'    =>  'admin.create'
            ]);

            Route::get('/product/{product_id}', [
                'uses'  =>  'AdminController@editProduct',
                'as'    =>  'admin.edit'
            ]);

            Route::put('/product/{product_id}', [
                'uses'  =>  'AdminController@updateProduct',
                'as'    =>  'admin.update'
            ]);

            Route::delete('/product/{product_id}', [
                'uses'  =>  'AdminController@deleteProduct',
                'as'    =>  'admin.delete'
            ]);

            Route::post('/assign-roles', [
                'uses'  =>  'AdminController@postAdminAssignRoles',
                'as'    =>  'admin.assign'
            ]);
        });
    });
});


Route::get('/cart', [
    'uses' => 'ProductController@cartIndex',
    'as'  => 'cart.index'
]);

Route::get('/cart/add/{slug}/{quantity}', [
    'uses' => 'ProductController@addToCart',
    'as'   => 'cart.add'
]);

Route::post('/cart/update/{rowId}', [
    'uses' => 'ProductController@updateCart',
    'as'    => 'cart.update'
]);

Route::get('/cart/empty', [
    'uses' => 'ProductController@emptyCart',
    'as'    => 'cart.empty'
]);

Route::get('/cart/removeItem/{rowId}', [
    'uses' => 'ProductController@removeItem',
    'as'    => 'cart.remove'
]);
