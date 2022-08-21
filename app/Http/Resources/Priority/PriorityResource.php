<?php

namespace App\Http\Resources\Priority;

use App\Models\Priority;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PriorityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Priority $priority */
        $priority = $this;
        return [
            'id' => $priority->id,
            'value' => $priority->value,
            'name' => $priority->name,
        ];
    }
}
