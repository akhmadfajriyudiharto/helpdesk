<?php

namespace App\Http\Resources\TicketReply;

use App\Models\TicketReply;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Str;

class TicketReplyQuickDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var TicketReply $ticketReply */
        $ticketReply = $this;
        return [
            'id' => $ticketReply->id,
            'body' => Str::words(strip_tags(str_ireplace(['<br />', '<br>', '<br/>'], ' ', $ticketReply->body)), 50),
            'created_at' => $ticketReply->created_at->toISOString(),
        ];
    }
}
