<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
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
            'gender' => $this->gender,
            'age' => $this->age,
            'height' => $this->height,
            'weight' => $this->weight,
            'blood_pressure' => $this->blood_pressure,
            'temperature' => $this->temperature,
        ];
    }
}
