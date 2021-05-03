<?php

namespace App\Http\Resources\Periods;

use Illuminate\Http\Resources\Json\JsonResource;

class PeriodResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'started_at' => $this->started_at->format('Y-m-d'),
            'ended_at' => $this->ended_at->format('Y-m-d'),
            'status' => $this->status
        ];
    }
}
