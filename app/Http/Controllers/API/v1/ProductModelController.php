<?php

namespace App\Http\Controllers\API\v1;

use Illuminate\Http\Request;
use App\Models\Produce\Product;
use App\Http\Controllers\Controller;
use App\Models\Produce\ProductModel;

class ProductModelController extends Controller
{
    public function index(Product $product)
    {
        return $product->models;
    }

    public function show(Product $product, ProductModel $productModel)
    {
        if(!$product->hasModel($productModel))
        {
            return response()->json([
                'message' => 'Not Found'
            ], 404);
        }

        return $productModel;
    }
}
