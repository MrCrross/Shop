<?php

namespace App\Http\Controllers\API\v1;

use App\Models\Produce\Product;
use App\Http\Controllers\Controller;
use App\Models\Produce\ProductReview;
use App\Http\Requests\CreateReviewRequest;

class ProductReviewController extends Controller
{
    public function index(Product $product)
    {
        return $product->reviews;
    }

    public function total(Product $product)
    {
        return ProductReview::total($product);
    }

    public function store(CreateReviewRequest $request, Product $product)
    {
        $request->merge([
            'user_id'    => auth()->id(),
            'product_id' => $product->id
        ]);

        return ProductReview::create($request->input());
    }

    public function show(ProductReview $productReview)
    {
        return $productReview;
    }

    public function delete(ProductReview $productReview)
    {
        if($productReview->user_id != auth()->id())
        {
            return response()->json([
                'message' => 'Not Found'
            ], 404);
        }

        $productReview->delete();

        return $productReview;
    }
}
