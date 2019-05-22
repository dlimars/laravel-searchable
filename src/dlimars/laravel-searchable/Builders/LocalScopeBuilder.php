<?php
/**
 * Created by PhpStorm.
 * User: dlima
 * Date: 21/05/19
 * Time: 22:21
 */

namespace Dlimars\LaravelSearchable\Builders;

use Dlimars\LaravelSearchable\Clause;
use Illuminate\Database\Eloquent\Builder;

class LocalScopeBuilder implements BuilderContract
{
    /**
     * @param Builder $builder
     * @param Clause $clause
     * @return mixed
     */
    public function filter(Builder &$builder, Clause $clause)
    {
        $builder->{$clause->field}($clause->value);
    }
}