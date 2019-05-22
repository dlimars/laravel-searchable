<?php
/**
 * Created by PhpStorm.
 * User: dlima
 * Date: 21/05/19
 * Time: 22:26
 */

namespace Dlimars\LaravelSearchable;


class Clause
{
    /**
     * @var
     */
    public $field;

    /**
     * @var
     */
    public $value;

    /**
     * Clause constructor.
     * @param $field
     * @param $value
     */
    public function __construct($field, $value)
    {
        $this->field = $field;
        $this->value = $value;
    }
}