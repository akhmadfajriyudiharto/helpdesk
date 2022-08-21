<?php

namespace App\Http\Resources\Language;

use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LanguageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Language $language */
        $language = $this;
        return [
            'id' => $language->id,
            'locale' => $language->locale,
            'name' => $language->name
        ];
    }
}
