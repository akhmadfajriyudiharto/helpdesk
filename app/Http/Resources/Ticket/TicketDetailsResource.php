<?php

namespace App\Http\Resources\Ticket;

use App\Http\Resources\Department\DepartmentSelectResource;
use App\Http\Resources\TicketReply\TicketReplyDetailsResource;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketDetailsResource extends JsonResource
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
            'department' => new DepartmentSelectResource($ticket->department),
            'department_id' => $ticket->department_id,
            'created_at' => $ticket->created_at->toISOString(),
            'updated_at' => $ticket->updated_at->toISOString(),
            'ticketReplies' => TicketReplyDetailsResource::collection($ticket->ticketReplies()->orderByDesc('created_at')->get()),
        ];
    }
}
