<?php

namespace App\Filters;

abstract class BaseFilter
{
    public function handle($request, \Closure $next)
    {
        $builder = $next($request);

        if(request()->has($this->field()) && !empty(request($this->field()))) {

            $keyword = strtolower(request($this->field()));

            $builder->where($this->column(), 'like', '%'.$keyword.'%');
        }

        return $builder;

    }

    abstract public function field(): string;
    abstract public function column(): string;
}