<?php

namespace App\Http\Controllers\API\v1;

use Illuminate\Http\Request;
use App\Models\Produce\Product;
use SebastianBergmann\Timer\Timer;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Produce\ProductSearch;
use App\Models\Produce\ProductOptions;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * @var Timer
     */
    private $timer;

    public function __construct()
    {
        $this->timer = new Timer();
    }

    /**
     * @param Request $request
     */
    public function index(Request $request)
    {
        $this->timer->start();
        $searchEngine = new ProductSearch(
            new ProductOptions($request->input())
        );
        $products = $searchEngine->search();
        $duration = $this->timer->stop();

        Log::info('Show products', [
            'time' => $duration->asMilliseconds(),
            'params' => $request->input()
        ]);

        return $products;
    }

    /**
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($product)
    {
        $this->timer->start();

        $product = Product::firstWithRelations($product);

        $duration = $this->timer->stop();

        Log::info('Show product', [
            'time'      => $duration->asMilliseconds(),
            'product'   => $product
        ]);

        return $product;
    }

    /**
     * @param CreateProductRequest $request
     * @return Product
     */
    public function store(CreateProductRequest $request)
    {
        $request->merge(['user_id' => auth()->id()]);
        $createProduct = Product::create($request->input());

        Log::info('Created product', [
            'product' => $createProduct->id
        ]);

        return $createProduct;
    }

    /**
     * @param Product $product
     * @param UpdateProductRequest $request
     * @return Product
     */
    public function update(Product $product, UpdateProductRequest $request)
    {
        $product->update($request->input());

        Log::info('Update product', [
            'product' => $product->id,
            'user'    => auth()->id()
        ]);

        return $product;
    }

    /**
     * @param Product $product
     * @return Product
     */
    public function delete(Product $product)
    {
        $product->delete();

        Log::info('Delete product', [
            'product' => $product->id,
            'user'    => auth()->id()
        ]);

        return $product;
    }
}

