<?php

namespace App\Http\Controllers\API\v1;

use App\Models\User;
use App\Models\Produce\Product;
use App\Models\Produce\ProductLike;
use App\Http\Controllers\Controller;

class ProductLikeController extends Controller
{
    /**
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Product $product)
    {
        $user = User::find(auth()->id());

        if(ProductLike::likeExists($product, $user))
        {
            return response()->json([
                'message' => 'Like already exists'
            ], 422);
        }

        return ProductLike::like($product, $user);
    }

    /**
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Product $product)
    {
        $user = User::find(auth()->id());
        $productLike = ProductLike::findLike($product, $user);

        return $productLike->delete();
    }
}
