<?php

namespace Dlimars\LaravelSearchable;
use \Illuminate\Database\Eloquent\Builder;

trait Searchable {

	/**
	 * Apply filters in your QueryBuilder based in $fields
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $queryBuilder
	 * @param array $fields
	 *
	 */
	public function scopeSearch(Builder $queryBuilder, $fields=[]){

	}

}