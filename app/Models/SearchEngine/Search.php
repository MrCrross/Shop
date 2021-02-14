<?php

namespace App\Models\SearchEngine;

use Illuminate\Database\Eloquent\Model;

abstract class Search extends Model
{
    /**
     * @var string
     */
    protected $searchableModel;

    /**
     * @var SearchOptions
     */
    protected $searchOptions;

    /**
     * @var SearchOptions $searchOptions
     */
    public function __construct($searchOptions)
    {
        $this->searchOptions = $searchOptions;
    }

    public function search()
    {
        $query = $this->searchableModel::orderBy(
            $this->searchOptions->getSortedBy(), $this->searchOptions->getSortedType()
        );

        foreach($this->searchOptions->getWheres() as $condition)
        {
            list($column, $operator, $value) = $condition;
            if($value !== null)
            {
                $query->where($column, $operator, $value);
            }
        }

        return $query->paginate($this->searchOptions->getLimit());
    }
}
