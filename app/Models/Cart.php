<?php

namespace App\Models;

use App\Models\Produce\Product;
use App\Models\Produce\ProductModel;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    const ARCHIVE = 1;

    protected $fillable = [
        'user_id', 'product_id', 'model_id', 'amount'
    ];

    protected $hidden = [
        'archive'
    ];

    public function increaseAmount($delta)
    {
        $this->amount += $delta;
        return $this->save();
    }

    public function archive()
    {
        $this->archive = self::ARCHIVE;
        return $this->save();
    }

    /**
     * @param User $user
     * @param Product $product
     * @param ProductModel $productModel
     */
    public static function findBy(User $user, Product $product, ProductModel $productModel = null)
    {
        return self::where('user_id', '=', $user->id)->
                     where('product_id', '=', $product->id)->
                     where('model_id', '=', $productModel)->
                     first();
    }

    /**
     * @param User $user
     */
    public static function total(User $user)
    {
        return self::where('user_id', '=', $user->id)->
                     sum('amount');
    }

    public static function clear(User $user)
    {
        return self::where('user_id', '=', $user->id)->
                     where('archive', '!=', self::ARCHIVE)->
                     delete();
    }

    /**
     * @param int $amount
     * @param User $user
     * @param Product $product
     * @param ProductModel $productModel
     * @return mixed
     */
    public static function add($amount, User $user, Product $product, ProductModel $productModel = null)
    {
        if($cart = Cart::findBy($user, $product, $productModel))
        {
            $cart->increaseAmount($amount);
            return $cart;
        }

        $modelId = $productModel->id ?? null;

        return self::create([
            'amount'     => $amount,
            'user_id'    => $user->id,
            'product_id' => $product->id,
            'model_id'   => $modelId
        ]);
    }
}
