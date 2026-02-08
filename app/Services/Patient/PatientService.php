<?php

namespace App\Services\Patient;

use App\Http\Requests\Patient\PatientRequest;
use App\Models\Patient\Patient;
use App\Models\User;
use App\Models\Common\Master\UserRole;
use App\Traits\FileUploader;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\In;
use Termwind\Components\Hr;
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

    public function storePatient(PatientRequest $request): Model
    {
        DB::beginTransaction();
        try {
            $patientData = $request->fields();

            // Get patient role or use first active role as fallback
            $patientRole = UserRole::query()
                ->where('role_name', 'like', '%Patient%')
                ->where('active', 'YES')
                ->first();

            if (!$patientRole) {
                $patientRole = UserRole::query()
                    ->where('active', 'YES')
                    ->first();
            }

            if (!$patientRole) {
                throw new Exception('No active role found. Please create a role first.');
            }

            // Create user first
            $userData = [
                'user_name' => $patientData['name'],
                'full_name' => $patientData['name'],
                'role_id' => $patientRole->role_id,
                'email' => $patientData['email'] ?? null,
                'phone' => $patientData['phone'],
                'address' => $patientData['address'] ?? null,
                'password' => Hash::make('patient123'),
                'active' => 'NO',
                'created_by' => $patientData['created_by'] ?? null,
            ];

            $user = User::query()->create($userData);

            // Set user_id in patient data
            $patientData['user_id'] = $user->id;

            if (!empty($request->photo)) {
                $patientData['photo'] = $this->uploadMedia($request, 'photo', 'patient');
            }

            // Remove password from patient data as it's stored in users table
            unset($patientData['password']);

            $totalPatient = Patient::query()->count();

            $patientData['patient_id_number'] = 'P' . sprintf("%06d", $totalPatient + 1);

            $patient = Patient::query()->create($patientData);

            DB::commit();

            return $patient;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function getPatientById(int $patientId): Model|Builder
    {
        return Patient::query()->where('patient_id', $patientId)->first();
    }

    public function updatePatient(PatientRequest $request, int $patientId): Model
    {
        try {
            $patientData = $request->fields();
            // dd($patientData);

            $patientInfo = $this->getPatientById($patientId);

            if (!empty($request->photo)) {
                $patientData['photo'] = $this->updateMedia($request, 'photo', 'patient', $patientInfo['photo']);
            }

            $patientInfo->update($patientData);

            return $patientInfo;
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
