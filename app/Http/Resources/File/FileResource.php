<?php

namespace App\Http\Resources\File;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var File $file */
        $file = $this;
        return [
            'id' => $file->id,
            'uuid' => $file->uuid,
            'name' => $file->name,
            'size' => $file->size,
            'mime' => $file->mime,
            'extension' => $file->extension,
            'url' => $file->url(),
            'download' => $file->download(),
        ];
    }
}
