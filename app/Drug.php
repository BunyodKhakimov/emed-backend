<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
    protected $guarded = [];

    public function prescription()
    {
        return $this->belongsTo(Prescription::class, 'prescription_id', 'id');
    }
}
