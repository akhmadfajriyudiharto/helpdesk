<?php

namespace App\Http\Resources\CannedReply;

use App\Http\Resources\User\UserDetailsResource;
use App\Models\CannedReply;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CannedReplyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var CannedReply $cannedReply */
        $cannedReply = $this;
        return [
            'id' => $cannedReply->id,
            'user_id' => $cannedReply->user_id,
            'user' => new UserDetailsResource($cannedReply->user),
            'author' => Auth::id() === $cannedReply->user_id,
            'name' => $cannedReply->name,
            'body' => $cannedReply->body,
            'shared' => (bool) $cannedReply->shared,
            'created_at' => $cannedReply->created_at->toISOString(),
            'updated_at' => $cannedReply->updated_at->toISOString(),
        ];
    }
}
