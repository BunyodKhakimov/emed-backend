<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
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
            'doctor_id' => $this->doctor_id,
            'date' => $this->date,
            'time' => $this->time,
            'purpose' => $this->purpose,
            'is_approved' => $this->is_approved,
        ];
    }
}
