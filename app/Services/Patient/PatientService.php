<?php

namespace App\Services\Patient;

use App\Models\Patient\Patient;
use App\Traits\FileUploader;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class PatientService
{

    use FileUploader;

    public function getPatientList(Request $request): JsonResponse
    {
        $searchKeyword = $request->input('search');

        $query = Patient::query()->latest();

        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('photo', function ($row) {
                $photo = '<img src="' . 'uploads/patient/' . $row->photo . '" alt="Patient" class="rounded-circle" width="80" height="80">';

                return $photo;
            })->addColumn('info', function ($row) {
                $name = $row->name ?? '';
                $gender = $row->gender ?? '';
                $marital_status = $row->marital_status ?? '';
                $dob = $row->date_of_birth ?? '';
                $info = '<i class="fas fa-user-injured text-dark"></i> : ' . $name . '<br>' . '<i class="fas fa-venus-mars text-danger"></i> : ' . $gender . '<br>' . '<i class="fas fa-ring text-warning"></i> : ' . $marital_status . '<br>' . '<i class="fas fa-calendar-day text-success"></i> : ' . $dob;
                return $info;
            })->addColumn('contact_info', function ($row) {
                $email = $row->email ?? '';
                $phone = $row->phone ?? '';
                $address = $row->address ?? '';
                $contact_info = '<i class="fas fa-envelope text-primary"></i> : ' . $email . '<br>' . '<i class="fas fa-phone text-dark"></i> : ' . $phone . '<br>' . '<i class="fas fa-map-marked-alt text-danger"></i> : ' . $address;
                return $contact_info;
            })->addColumn('medical_info', function ($row) {
                $height = $row->height ?? '';
                $weight = $row->weight ?? '';
                $blood_group = $row->blood_group ?? '';
                $medical_info = '<i class="fas fa-ruler-vertical text-warning"></i> : ' . $height . '<br>' . '<i class="fas fa-weight text-info"></i> : ' . $weight . '<br>' . '<i class="fas fa-tint text-danger"></i> : ' . $blood_group;
                return $medical_info;
            })->addColumn('action', function ($row) {

                $editBtn = '<a href="' . route('patient.edit', $row->patient_id) . '" class="btn btn-icon btn-bg-info text-white btn-sm me-2"><i class="fas fa-edit text-white"></i></a>';

                $viewBtn = '<a href="' . route('patient.view', $row->patient_id) . '" class="btn btn-icon btn-bg-light btn-sm viewDrugBtn"><i class="fas fa-eye"></i></a>';

                $button = '<div class="btn-group" role="group" aria-label="Basic example">
                            ' . $editBtn . '
                            ' . $viewBtn . '
                            </div>';
                return $button;
            })
            ->rawColumns(['photo', 'info', 'contact_info', 'medical_info', 'action'])
            ->make(true);
    }
}
