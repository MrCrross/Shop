<?php

namespace App\Models\Produce;

use App\Models\SearchEngine\SearchOptions;

class ProductOptions extends SearchOptions
{
    public function __construct(array $options)
    {
        parent::__construct($options);

        $this->addCondition('category_id', '=', $options['category_id'] ?? null);
    }
}
