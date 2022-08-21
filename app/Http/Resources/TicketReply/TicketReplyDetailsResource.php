<?php

namespace App\Http\Resources\TicketReply;

use App\Http\Resources\File\FileResource;
use App\Http\Resources\User\UserDetailsResource;
use App\Models\TicketReply;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketReplyDetailsResource extends JsonResource
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
            'user' => new UserDetailsResource($ticketReply->user),
            'body' => preg_replace("/<a(.*?)>/", "<a$1 target=\"_blank\">", $ticketReply->body),
            'created_at' => $ticketReply->created_at->toISOString(),
            'attachments' => FileResource::collection($ticketReply->ticketAttachments)
        ];
    }
}
