<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    protected $guarded = [];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id', 'id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id', 'id');
    }

    public function drugs()
    {
        return $this->hasMany(Drug::class, 'prescription_id', 'id');
    }
}
