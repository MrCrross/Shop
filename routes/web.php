<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Главная страница
Route::get('/', function () {
    return view('index') ;
});

// Страница контактов
Route::get('/contact', function () {
    return view('contact') ;
});

//Страницы авторизации
Route::group(['prefix' => 'auth'], function () {
    // Вход
    Route::get('/login', function () {return view('auth/login') ;});
    // Регистрация
    Route::get('/registration', function () { return view('auth/registration') ;});
    // Замена пароля
    Route::get('/ChangePass', function () { return view('auth/ChangePassword') ;});
    // Замена почты
    Route::get('/ChangeEmail', function () { return view('auth/ChangeEmail') ;});
});

// Страницы корзины и оплаты
Route::group(['prefix' => 'profile'], function () {
    // Корзина
    Route::get('/', function () {return view('profile/profile') ;});
    // Страница оплаты
    Route::get('/tracking', function () {return view('profile/tracking') ;});
});

// Страницы связанные с товаром
Route::group(['prefix' => 'shop'], function () {
    // Главная страница магазина
    Route::get('/', function () {return view('shop/index') ;});
    // Страница продукта
    Route::get('{product}', function () {return view('shop/product') ;});
});

// Страницы корзины и оплаты
Route::group(['prefix' => 'cart'], function () {
    // Корзина
    Route::get('/', function () {return view('cart/cart') ;});
    // Страница оплаты
    Route::get('/pay', function () {return view('cart/pay') ;});
});




// Трекер товара
Route::get('/tracking', function () {
    return require '../frontend/tracking.html' ;
});
// confirmation
Route::get('/confirmation', function () {
    return require '../frontend/confirmation.html' ;
});
// checkout
Route::get('/checkout', function () {
    return require '../frontend/checkout.html' ;
});

// Блог
Route::get('/blog', function () {
    return require '../frontend/blog.html' ;
});



