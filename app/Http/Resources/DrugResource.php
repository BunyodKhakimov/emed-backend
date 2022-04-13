<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DrugResource extends JsonResource
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
            'name' => $this->name,
            'start_date' => $this->start_date,
            'period' => $this->period,
            'take_time' => $this->take_time,
            'dose' => $this->dose,
            'every_day' => $this->every_day,
        ];
    }
}
