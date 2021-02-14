<?php

namespace App\Models\Produce;

use App\Models\SearchEngine\Search;

class ProductSearch extends Search
{
    /**
     * @var string
     */
    protected $searchableModel = Product::class;
}
