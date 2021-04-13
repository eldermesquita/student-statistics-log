<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'surname' => $this->surname,
            'abbreviated_name' => $this->abbreviated_name,
            'patronymic' => $this->patronymic,
            'email' => $this->email,
            'role' => $this->role,
            'session' => $this->session
        ];
    }
}
