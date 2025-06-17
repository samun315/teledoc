<?php

namespace App\Services\Doctor;

use App\Http\Requests\Doctor\DoctorRequest;
use App\Http\Requests\Patient\PatientRequest;
use App\Models\Doctor\Doctor;
use App\Models\Patient\Patient;
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

class DoctorService
{

    use FileUploader;

    public function getDoctorList(Request $request): JsonResponse
    {
        $searchKeyword = $request->input('search');
        $departmentId = $request->input('department_id');

        $query = Doctor::with(['department', 'degrees'])->latest();

        if ($searchKeyword) {
            $query->where(function ($q) use ($searchKeyword) {
                $q->where('title', 'like', "%{$searchKeyword}%")
                    ->orWhere('name', 'like', "%{$searchKeyword}%")
                    ->orWhere('email', 'like', "%{$searchKeyword}%")
                    ->orWhere('address', 'like', "%{$searchKeyword}%")
                    ->orWhere('status', 'like', "%{$searchKeyword}%")
                    ->orWhere('phone', 'like', "%{$searchKeyword}%")
                    ->orWhereHas('department', function ($subQuery) use ($searchKeyword) {
                        $subQuery->where('department_name', 'like', "%{$searchKeyword}%");
                    });
            });
        }

        if ($departmentId) {
            $query->where('department_id', $departmentId);
        }


        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('photo', function ($row) {
                return '<img src="' . asset('uploads/doctor/' . $row->photo) . '" alt="Doctor" class="rounded-circle" width="80" height="80">';
            })
            ->addColumn('info', function ($row) {
                $name = e($row->name);
                $department = e($row->department->department_name ?? '');

                $degreesHtml = '';
                foreach ($row->degrees as $degree) {
                    $title = e($degree->degree_title);
                    $desc = e($degree->description);
                    $degreesHtml .= "<p class='fas fa-ring text-warning'><strong> {$title}</strong> {$desc}</p>";
                }

                return "{$name}<br><p class='badge badge-info'>{$department}</p><br>{$degreesHtml}";
            })
            ->addColumn('contact_info', function ($row) {
                $email = e($row->email);
                $phone = e($row->phone);
                $address = e($row->address);

                return "<i class='fas fa-envelope text-primary'></i> : {$email}<br>
                <i class='fas fa-phone text-dark'></i> : {$phone}<br>
                <i class='fas fa-map-marked-alt text-danger'></i> : {$address}";
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('doctor.edit', $row->doctor_id);
                $viewUrl = route('doctor.view', $row->doctor_id);

                return "<div class='btn-group' role='group'>
                    <a href='{$editUrl}' class='btn btn-icon btn-bg-info text-white btn-sm me-2'><i class='fas fa-edit'></i></a>
                    <a href='{$viewUrl}' class='btn btn-icon btn-bg-light btn-sm viewDoctorBtn'><i class='fas fa-eye'></i></a>
                </div>";
            })
            ->rawColumns(['photo', 'info', 'contact_info', 'action'])
            ->make(true);
    }

    public function storeDoctor(DoctorRequest $request): Model
    {
        try {
            $doctorData = $request->fields();

            if (!empty($request->photo)) {
                $patientData['photo'] = $this->uploadMedia($request, 'photo', 'doctor');
            }

            $patientData['password'] = Hash::make($patientData['password']);

            $totalPatient = Doctor::query()->count();

            $patientData['patient_id_number'] = 'P' . sprintf("%06d", $totalPatient + 1);

            $patient = Patient::query()->create($patientData);

            return $patient;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function getDoctorById(int $doctorId): Model|Builder
    {
        return Doctor::query()->where('doctor_id', $doctorId)->first();
    }

    public function updateDoctor(DoctorRequest $request, int $doctorId): Model
    {
        try {
            $patientData = $request->fields();
            // dd($patientData);

            $patientInfo = $this->getDoctorById($doctorId);

            if (!empty($request->photo)) {
                $patientData['photo'] = $this->updateMedia($request, 'photo', 'doctor', $patientInfo['photo']);
            }

            $patientInfo->update($patientData);

            return $patientInfo;
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
