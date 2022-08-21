<?php

namespace App\Http\Resources\Ticket;

use App\Http\Resources\Department\DepartmentSelectResource;
use App\Http\Resources\Label\LabelSelectResource;
use App\Http\Resources\Priority\PriorityResource;
use App\Http\Resources\Status\StatusResource;
use App\Http\Resources\TicketReply\TicketReplyQuickDetailsResource;
use App\Http\Resources\User\UserDetailsResource;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Ticket $ticket */
        $ticket = $this;
        return [
            'id' => $ticket->id,
            'uuid' => $ticket->uuid,
            'subject' => $ticket->subject,
            'lastReply' => new TicketReplyQuickDetailsResource($ticket->ticketReplies->last()),
            'status' => new StatusResource($ticket->status),
            'priority' => new PriorityResource($ticket->priority),
            'department' => new DepartmentSelectResource($ticket->department),
            'labels' => LabelSelectResource::collection($ticket->labels),
            'user' => new UserDetailsResource($ticket->user),
            'agent' => new UserDetailsResource($ticket->agent),
            'closedBy' => new UserDetailsResource($ticket->closedBy),
            'closed_at' => $ticket->closed_at ? $ticket->closed_at->toISOString() : null,
            'created_at' => $ticket->created_at->toISOString(),
            'updated_at' => $ticket->updated_at->toISOString()
        ];
    }
}
