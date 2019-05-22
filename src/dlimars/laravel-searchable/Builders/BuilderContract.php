<?php
/**
 * Created by PhpStorm.
 * User: dlima
 * Date: 21/05/19
 * Time: 22:23
 */

namespace Dlimars\LaravelSearchable\Builders;


use Dlimars\LaravelSearchable\Clause;
use Illuminate\Database\Eloquent\Builder;

interface BuilderContract
{
    /**
     * @param Builder $query
     * @param Clause $clause
     * @return mixed
     */
    public function filter(Builder &$query, Clause $clause);
}