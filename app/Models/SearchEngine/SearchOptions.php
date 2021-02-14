<?php

namespace App\Models\SearchEngine;

class SearchOptions
{
    /**
     * @var int
     */
    private $limit = 10;

    /**
     * @var string
     */
    private $sorted_by = 'created_at';

    /**
     * @var string
     */
    private $sorted_type = 'ASC';

    /**
     * Example:
     *      ```php
     *      $wheres = [
     *          ['category_id', '=', 1]
     *      ]
     *      ```php
     *      ```sql
     *      WHERE category_id = 1
     *      ```sql
     * @var array
     */
    protected $wheres = [

    ];

    /**
     * @var array $options
     */
    public function __construct(array $options)
    {
        foreach($options as $key => $value)
        {
            if(property_exists($this, $key))
            {
                $this->$key = $value;
            }
        }
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        return property_exists($this, $key) ? $this->$key : null;
    }

    public function addCondition($column, $operator, $value)
    {
        $this->wheres[] = [$column, $operator, $value];
    }

    /**
     * @return array
     */
    public function getWheres()
    {
        return $this->wheres;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @return string
     */
    public function getSortedBy()
    {
        return $this->sorted_by;
    }

    /**
     * @return string
     */
    public function getSortedType()
    {
        return $this->sorted_type;
    }
}
