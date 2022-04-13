<?php

namespace App\Http\Controllers;


use App\Doctor;
use App\Http\Requests\DoctorRequest;
use App\Http\Resources\DoctorCollection;
use App\Http\Resources\DoctorResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

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

        if ($request->hasFile('profile_image'))
            $data['image_path'] = $this->saveProfileImage($request);

        $data['user_id'] = auth()->user()->id;

        $doctor = Doctor::create($data);

        return new DoctorResource($doctor);
    }

    public function update(DoctorRequest $request, Doctor $doctor)
    {
        $data = $request->validated();

        if ($request->hasFile('profile_image')) {
            File::delete(public_path('/images/profile').'/'.$doctor->image_path);
            $data['image_path'] = $this->saveProfileImage($request);
        }

        $doctor->update($data);

        return new DoctorResource($doctor);
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
    }

    protected function saveProfileImage($request)
    {
        $image = $request->file('profile_image');

        $image_name = Carbon::now()->format('Ydm_His') . '.' . $image->extension();
        $image->move(public_path('/images/profile'), $image_name);

        return "/images/profile/" . $image_name;
    }
}
