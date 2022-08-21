<?php

namespace App\Http\Resources\Label;

use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LabelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Label $label */
        $label = $this;
        return [
            'id' => $label->id,
            'name' => $label->name,
            'color' => $label->color,
            'created_at' => $label->created_at->toISOString()
        ];
    }
}
