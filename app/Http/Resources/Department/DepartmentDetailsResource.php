<?php

namespace App\Http\Resources\Department;

use App\Http\Resources\User\UserDetailsResource;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentDetailsResource extends JsonResource
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
            'all_agents' => (bool) $department->all_agents,
            'public' => (bool) $department->public,
            'agents' => !$department->all_agents ? UserDetailsResource::collection($department->agent->take(5)) : []
        ];
    }
}
