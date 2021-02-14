<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login');
    Route::get('me', 'AuthController@me')->middleware('auth');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('logout', 'AuthController@logout')->middleware('auth');
});


Route::group(['prefix' => 'users'], function () {
    Route::post('', 'UserController@create');
});

Route::group(['prefix' => 'rules'], function () {
    Route::get('', 'RuleController@index')->middleware('auth');
});

Route::group(['prefix' => 'security'], function () {
    Route::put('email', 'SecurityController@changeEmail')->middleware('auth');
    Route::put('password', 'SecurityController@changePassword')->middleware('auth');
});

Route::group(['prefix' => 'products'], function () {
    Route::get('', 'ProductController@index');
    Route::get('{product}', 'ProductController@show');
    Route::post('', "ProductController@store")->middleware('check:admin');
    Route::put('{product}', 'ProductController@update')->middleware('check:admin');
    Route::delete('{product}', 'ProductController@delete')->middleware('check:admin');

    Route::post('{product}/like', 'ProductLikeController@store')->middleware('auth');
    Route::delete('{product}/like', 'ProductLikeController@delete')->middleware('auth');

    Route::post('{product}/carts', 'CartController@store');

    Route::group(['prefix' => '{product}/reviews'], function () {
        Route::get('', 'ProductReviewController@index');
        Route::get('totals', 'ProductReviewController@total');
        Route::post('', 'ProductReviewController@store')->middleware('auth');
    });

    Route::group(['prefix' => '{product}/comments'], function () {
        Route::get('', 'ProductCommentController@index');
        Route::post('', 'ProductCommentController@store');
        Route::get('{productComment}', 'ProductCommentController@show');
    });

    Route::group(['prefix' => '{product}/models'], function () {
        Route::get('', 'ProductModelController@index');
        Route::get('{productModel}', 'ProductModelController@show');
    });
});

Route::group(['prefix' => 'reviews'], function () {
    Route::delete('{productReview}', 'ProductReviewController@delete')->middleware('auth');
});

Route::group(['prefix' => 'carts', 'middleware' => ['auth']], function () {
    Route::get('', 'CartController@index');
    Route::get('total', 'CartController@total');
    Route::get('{cart}', 'CartController@show');
    Route::put('{cart}', 'CartController@update')->middleware('can:owner,cart');
    Route::delete('{cart}', 'CartController@delete')->middleware('can:owner,cart');
});

Route::group(['prefix' => 'categories'], function () {
    Route::get('', 'CategoryController@index');
});
