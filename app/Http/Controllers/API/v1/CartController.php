<?php

namespace App\Http\Controllers\API\v1;

use App\Models\User;
use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\Produce\Product;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Produce\ProductModel;

class CartController extends Controller
{
    public function index()
    {
        $user = User::find(auth()->id());

        Log::info('Show products in cart', [
            'owner' => $user->email
        ]);

        return $user->cartsProducts();
    }

    public function total()
    {
        $user = User::find(auth()->id());

        Log::info('Show number of products in cart', [
            'owner' => $user->email
        ]);

        return Cart::total($user);
    }

    /**
     * @param Request $request
     * @param Product $product
     * @param ProductModel $productModel
     * @return Cart
     */
    public function store(Request $request, Product $product, ProductModel $productModel = null)
    {
        $user = User::find(auth()->id());
        $amount = (int)$request->input('amount');

        Log::info('Save product to cart', [
            'user'    => $user->id,
            'product' => $product->id,
            'model'   => $productModel ? $productModel->id : null,
            'amount'  => $amount
        ]);

        return Cart::add($amount, $user, $product, $productModel);
    }

    /**
     * @param Cart $cart
     * @return Cart
     */
    public function show(Cart $cart)
    {
        return $cart;
    }

    /**
     * @param Cart $cart
     * @param Request $request
     * @return Cart
     */
    public function update(Cart $cart, Request $request)
    {
        $cart->update($request->input());

        return $cart;
    }

    /**
     * @param Cart $cart
     * @return Cart
     */
    public function delete(Cart $cart)
    {
        $cart->archive();

        return $cart;
    }

    public function clear()
    {
        $user = User::find(auth()->id());

        return Cart::clear($user);
    }
}
