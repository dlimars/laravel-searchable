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

class BetweenBuilder implements BuilderContract
{
    /**
     * @param Builder $builder
     * @param Clause $clause
     * @return mixed
     */
    public function filter(Builder &$builder, Clause $clause)
    {
        if (is_array($clause->value) && count($clause->value) == 2) {
            $this->applyFilter($builder, $clause);
        }
    }

    /**
     * @param Builder $builder
     * @param Clause $clause
     */
    private function applyFilter(Builder $builder, Clause $clause)
    {
        if(isset($clause->value[0]) && !empty($clause->value[0])) {
            $builder->where($clause->field, ">=", $clause->value[0]);
        }

        if(isset($clause->value[1]) && !empty($clause->value[1])) {
            $builder->where($clause->field, "<=", $clause->value[1]);
        }
    }
}