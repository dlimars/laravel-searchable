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
     * @return Builder
     */
	public function scopeSearch(Builder $queryBuilder, $fields=[]){

		if (isset($this->searchable)) {

			foreach ($fields as $field => $value) {

				if (!empty($value) && array_key_exists($field, $this->searchable)) {

                    $searchType = $this->searchable[$field];

					switch ($searchType) {
						// compare equals values
						case 'MATCH':
							$this->applyEqualsSearch($queryBuilder, $field, $value);
							break;
						
						// compare like values
						case 'LIKE':
							$this->applyLikeSearch($queryBuilder, $field, $value);
							break;

						// compare between values
						case 'BETWEEN':
							$this->applyBetweenSearch($queryBuilder, $field, $value);
                            break;

                        // call local scope function
                        default:
                            $this->callLocalScope($queryBuilder, $searchType, $value);
					}
				}
			}
		}
		return $queryBuilder;
	}

    /**
     * @param Builder $queryBuilder
     * @param $field
     * @param array $value
     */
    public function applyBetweenSearch(Builder &$queryBuilder, $field, $value = [])
    {
        if (is_array($value) && count($value) == 2) {
            if(isset($value[0]) && !empty($value[0])) {
                $queryBuilder->where($field, ">=", $value[0]);
            }
            if(isset($value[1]) && !empty($value[1])) {
                $queryBuilder->where($field, "<=", $value[1]);
            }
        }
    }

    /**
     * @param Builder $queryBuilder
     * @param $field
     * @param $value
     */
    public function applyLikeSearch(Builder &$queryBuilder, $field, $value)
    {
        array_map(function($value) use ($queryBuilder, $field){
            $queryBuilder->where($field, "LIKE", "%".$value."%");
        }, explode(" ", $value));
    }

    /**
     * @param Builder $queryBuilder
     * @param $field
     * @param $value
     */
    public function applyEqualsSearch(Builder &$queryBuilder, $field, $value)
    {
        $queryBuilder->where($field, $value);
    }

    /**
     * @param Builder $queryBuilder
     * @param $scopeName
     * @param $value
     */
    public function callLocalScope(Builder &$queryBuilder, $scopeName, $value)
    {
        $queryBuilder->{$scopeName}($value);
    }
}