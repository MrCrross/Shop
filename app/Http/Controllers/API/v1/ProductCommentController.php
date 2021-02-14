<?php

namespace App\Http\Controllers\API\v1;

use App\Models\Produce\Product;
use App\Http\Controllers\Controller;
use App\Models\Produce\ProductComment;
use App\Http\Requests\CreateCommentRequest;

class ProductCommentController extends Controller
{
    public function index(Product $product)
    {
        return $product->paginateComments();
    }

    public function store(Product $product, CreateCommentRequest $request)
    {
        $request->merge([
            'user_id'    => auth()->id(),
            'product_id' => $product->id
        ]);

        return ProductComment::create($request->input());
    }

    public function show(Product $product, ProductComment $productComment)
    {
        $productComment->reply_comments = $productComment->paginateReplyComments();

        return $productComment;
    }
}
