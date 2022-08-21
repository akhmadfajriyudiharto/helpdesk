<?php

namespace App\Http\Resources\UserRole;

use App\Models\UserRole;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserRoleEditResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     * @throws Exception
     */
    public function toArray($request)
    {
        /** @var UserRole $userRole */
        $userRole = $this;
        return [
            'id' => $userRole->id,
            'name' => $userRole->name,
            'type' => $userRole->type,
            'dashboard_access' => (bool) $userRole->dashboard_access,
            'permissions' => json_decode((string) $userRole->permissions, true, 512, JSON_THROW_ON_ERROR),
        ];
    }
}
