<?php

namespace App\Http\Controllers;

use App\Doctor;
use App\Http\Requests\PatientRequest;
use App\Http\Resources\PatientResource;
use App\Patient;

class PatientController extends Controller
{
    public function show(Patient $patient)
    {
        return new PatientResource($patient);
    }

    public function store(PatientRequest $request)
    {
        $data = $request->validated();

        $data['user_id'] = auth()->user()->id;

        $patient = Patient::create($data);

        return new PatientResource($patient);
    }

    public function update(PatientRequest $request, Patient $patient)
    {
        $data = $request->validated();

        $patient->update($data);

        return new PatientResource($patient);
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();
    }
}
