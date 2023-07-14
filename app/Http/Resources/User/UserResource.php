<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /** @var \App\Models\User $user */
        $user = $this;
        return [
            'username' => $user->user_username,
            'name' => $user->user_name,
            'key' => $user->user_auth_key,
            'avatar' => $user->user_avatar,
            'org_code' => $user->user_current_organization_code,
            'expire_end_time' => $user->user_expire_end_time,
            'status' => $user->user_status,
        ];
    }
}
