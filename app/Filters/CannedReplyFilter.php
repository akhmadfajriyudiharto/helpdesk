<?php

namespace App\Filters;

use EloquentFilter\ModelFilter;

class CannedReplyFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    public function search($search): CannedReplyFilter
    {
        return $this->where('name', 'LIKE', '%'.$search.'%')
            ->orWhere('body', 'LIKE', '%'.$search.'%');
    }
}
