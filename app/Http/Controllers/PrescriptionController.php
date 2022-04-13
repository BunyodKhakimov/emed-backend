<?php

namespace App\Http\Controllers;

use App\Drug;
use App\Http\Requests\PrescriptionRequest;
use App\Http\Resources\PrescriptionCollection;
use App\Http\Resources\PrescriptionResource;
use App\Prescription;
use Carbon\Carbon;

class PrescriptionController extends Controller
{
    public function index()
    {
        return new PrescriptionCollection(auth()->user()->prescriptions);
    }

    public function show(Prescription $prescription)
    {
        return new PrescriptionResource($prescription);
    }

    public function store(PrescriptionRequest $request)
    {
        $data = $request->validated();

        $data['patient_id'] = auth()->user()->id;
        $drugs = $data['drugs'];
        unset($data['drugs']);

        $prescription = Prescription::create($data);
        $this->storeDrugs($prescription, $drugs);

        return new PrescriptionResource($prescription);
    }

    public function update(PrescriptionRequest $request, Prescription $prescription)
    {
        $data = $request->validated();

        $drugs = $data['drugs'];
        unset($data['drugs']);

        $prescription->update($data);
        $prescription->drugs()->delete();
        $this->storeDrugs($prescription, $drugs);

        return new PrescriptionResource($prescription);
    }

    public function destroy(Prescription $prescription)
    {
        $prescription->drugs()->delete();
        $prescription->delete();
    }

    protected function storeDrugs($prescription, $drugs)
    {
        foreach ($drugs as $drug)
            $prescription->drugs()->save(new Drug($drug));
    }
}
