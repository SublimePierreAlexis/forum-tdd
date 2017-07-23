<?php

namespace App\Filters;

use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

abstract class Filters
{
    /**
     * @var array
     */
    protected $filters = [];
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var Builder
     */
    protected $builder;

    /**
     * Filters constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param $builder
     *
     * @return Builder
     */
    public function apply($builder)
    {
        $this->builder = $builder;

        collect($this->getFilters())
            ->filter(function ($value, $filter) {
                return method_exists($this, $filter);
            })
            ->each(function ($value, $filter) {
                $this->$filter($value);
            });

        return $this->builder;
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return collect($this->request->intersect($this->filters));
    }
}