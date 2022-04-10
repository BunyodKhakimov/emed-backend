<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
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
            'speciality' => $this->speciality,
            'info' => $this->info,
            'patients' => $this->patients,
            'experience' => $this->experience,
            'rating' => $this->rating,
        ];
    }
}
