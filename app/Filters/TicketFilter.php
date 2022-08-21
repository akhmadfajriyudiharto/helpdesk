<?php

namespace App\Filters;

use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;

class TicketFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    public function search($search): TicketFilter
    {
        return $this->where('subject', 'LIKE', '%'.$search.'%')
            ->orWhereHas('ticketReplies', function (Builder $query) use ($search) {
                $query->where('body', 'LIKE', '%'.$search.'%');
            });
    }

    public function user($user): TicketFilter
    {
        return $this->whereHas('user', function (Builder $query) use ($user) {
            $query->where('name', 'LIKE', '%'.$user.'%')
                ->orWhere('email', 'LIKE', '%'.$user.'%');
        });
    }

    public function agents($agents): TicketFilter
    {
        return $this->whereIn('agent_id', $agents);
    }

    public function departments($departments): TicketFilter
    {
        return $this->whereIn('department_id', $departments);
    }

    public function labels($labels): TicketFilter
    {
        return $this->whereHas('labels', function (Builder $query) use ($labels) {
            $query->whereIn('id', $labels);
        });
    }

    public function status($status): TicketFilter
    {
        return $this->where('status_id', '=', $status);
    }

    public function statuses($statuses): TicketFilter
    {
        return $this->whereIn('status_id', $statuses);
    }

    public function priorities($priorities): TicketFilter
    {
        return $this->whereIn('priority_id', $priorities);
    }
}
