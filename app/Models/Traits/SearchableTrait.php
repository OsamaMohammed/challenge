<?php

namespace App\Models\Traits;

/**
 * Search Trait
 * @property array $searchables
 */
trait SearchableTrait
{
    /**
     * Search for text
     *
     * @param [type] $query
     * @param [type] $val
     * @param array $fields
     *
     * @return void
     */
    public function scopeSearch($query, $val)
    {
        $fields = $this::$searchables ?? [];
        $query = $query->where(function ($query) use ($fields, $val) {
            foreach ($fields as $field) {
                $query = $query->orWhere($field, 'like', "%$val%");
            }
        });
        return $query;
    }

}
