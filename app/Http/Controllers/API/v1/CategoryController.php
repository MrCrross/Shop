<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Produce\ProductCategory;

class CategoryController extends Controller
{
    public function index()
    {
        return ProductCategory::get();
    }
}
