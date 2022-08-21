<?php

namespace App\Http\Resources\Department;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Department $department */
        $department = $this;
        return [
            'id' => $department->id,
            'name' => $department->name,
            'all_agents' => $department->all_agents,
            'public' => $department->public,
            'agents' => $department->agent()->pluck('id')
        ];
    }
}
