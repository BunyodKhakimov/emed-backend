<?php

namespace App\Http\Controllers;


use App\Doctor;
use App\Http\Requests\DoctorRequest;
use App\Http\Resources\DoctorCollection;
use App\Http\Resources\DoctorResource;

class DoctorController extends Controller
{
    public function index()
    {
        return new DoctorCollection(Doctor::all());
    }

    public function show(Doctor $doctor)
    {
        return new DoctorResource($doctor);
    }

    public function store(DoctorRequest $request)
    {
        $data = $request->validated();

        $data['user_id'] = auth()->user()->id;

        $doctor = Doctor::create($data);

        return new DoctorResource($doctor);
    }

    public function update(DoctorRequest $request, Doctor $doctor)
    {
        $data = $request->validated();

        $doctor->update($data);

        return new DoctorResource($doctor);
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
    }
}
