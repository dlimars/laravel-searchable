<?php

namespace Dlimars\LaravelSearchable;


use Dlimars\LaravelSearchable\Builders\BuilderContract;
use Dlimars\LaravelSearchable\Builders\LocalScopeBuilder;
use \Illuminate\Database\Eloquent\Builder;

trait Searchable {

    /**
     * Apply filters in your QueryBuilder based in $fields
     *
     * @param Builder $builder
     * @param array $fields
     * @return Builder
     */
	public function scopeSearch(Builder $builder, $fields = [])
    {
		if (isset($this->searchable)) {
            $this->applySearch($builder, $fields);
		}

		return $builder;
	}

    /**
     * @param Builder $builder
     * @param array $fields
     */
    private function applySearch(Builder $builder, $fields = [])
    {
        foreach ($fields as $field => $value) {
            $this->filterField($builder, $field, $value);
        }
    }

    /**
     * @param Builder $queryBuilder
     * @param $field
     * @param $value
     */
    private function filterField(Builder $queryBuilder, $field, $value)
    {
        if ($this->isValidField($field, $value)) {
            $builder = $this->getBuilder($field);
            $clause  = $this->getClause($field, $value);
            $builder->filter($queryBuilder, $clause);
        }
    }

    /**
     * @param $field
     * @param $value
     * @return bool
     */
    private function isValidField($field, $value)
    {
        return !empty($value) && array_key_exists($field, $this->searchable);
    }

    /**
     * @param $field
     * @return BuilderContract
     */
    private function getBuilder($field)
    {
        $type = $this->getSearchType($field);

        if ($this->scopeExists($type)) {
            return app(LocalScopeBuilder::class);
        }

        return $this->makeBuilder($type);
    }

    /**
     * @param $type
     * @return BuilderContract
     */
    private function makeBuilder($type)
    {
        $className  = ucfirst(strtolower($type)) . "Builder";
        $className  = __NAMESPACE__ . "\\Builders\\{$className}";
        return app($className);
    }

    /**
     * @param $field
     * @param $value
     * @return Clause
     */
    private function getClause($field, $value)
    {
        $type = $this->getSearchType($field);

        if ($this->scopeExists($type)) {
            return new Clause($type, $value);
        }

        return new Clause($field, $value);
    }

    /**
     * @param $field
     * @return mixed
     */
    private function getSearchType($field)
    {
        return $this->searchable[$field];
    }

    /**
     * @param $scopeName
     * @return bool
     */
    private function scopeExists($scopeName)
    {
        return method_exists(
            $this, "scope" . ucfirst($scopeName)
        );
    }
}