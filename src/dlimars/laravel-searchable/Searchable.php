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

		if (isset($this->searchable)) {

			foreach ($fields as $field => $value) {

				if (array_key_exists($field, $this->searchable)) {

					switch ($this->searchable[$field]) {
						// compare equals values
						case 'MATCH':
							$queryBuilder->where($field, $value);
							break;
						
						// compare like values
						case 'LIKE':
							array_map(function($value) use ($queryBuilder, $field){
								$queryBuilder->where($field, "LIKE", "%".$value."%");
							}, explode(" ", $value));
							break;

						// compare between values
						case 'BETWEEN':
							if (is_array($value) && count($value) == 2) {
								if(isset($value[0]) && !empty($value[0])) {
									$queryBuilder->where($field, ">=", $value[0]);
								}
								if(isset($value[1]) && !empty($value[1])) {
									$queryBuilder->where($field, "<=", $value[1]);
								}
							}
					}
				}
			}
		}
		return $queryBuilder;
	}

}