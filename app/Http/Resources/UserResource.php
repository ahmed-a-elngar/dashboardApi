<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            =>  $this->id,
            'user_name'          =>  $this->user_name,
            'email'         =>  $this->email,
            'phone'  =>  $this->phone,
            'profile_picture'  =>  $this->profile_picture,
            'token' => $this->token
        ];
    }
}
