<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatientRequest;
use App\Http\Resources\PatientResource;
use App\Patient;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class PatientController extends Controller
{
    public function show(Patient $patient)
    {
        return new PatientResource($patient);
    }

    public function store(PatientRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('profile_image'))
            $data['image_path'] = $this->saveProfileImage($request);

        $data['user_id'] = auth()->user()->id;

        $patient = Patient::create($data);

        return new PatientResource($patient);
    }

    public function update(PatientRequest $request, Patient $patient)
    {
        $data = $request->validated();

        if ($request->hasFile('profile_image')) {
            File::delete(public_path('/images/profile') . '/' . $patient->image_path);
            $data['image_path'] = $this->saveProfileImage($request);
        }

        $patient->update($data);

        return new PatientResource($patient);
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();
    }

    protected function saveProfileImage($request)
    {
        $image = $request->file('profile_image');

        $image_name = Carbon::now()->format('Ydm_His') . '.' . $image->extension();
        $image->move(public_path('/images/profile'), $image_name);

        return "/images/profile/" . $image_name;
    }
}
