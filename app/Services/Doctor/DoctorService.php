<?php

namespace App\Services\Doctor;

use App\Http\Requests\Doctor\DoctorRequest;
use App\Http\Requests\Patient\PatientRequest;
use App\Models\Doctor\Doctor;
use App\Models\Doctor\DoctorDegree;
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
                $title = e($row->title);
                $name = e($row->name);
                $department = e($row->department->department_name ?? '');

                $degreesHtml = '';
                foreach ($row->degrees as $degree) {
                    $degree_title = e($degree->degree_title);
                    $desc = e($degree->degree_description);
                    $degreesHtml .= "<p class='text-dark'><strong> {$degree_title}</strong> :- {$desc}</p>";
                }

                return "<strong>{$row->title} {$name}</strong><br><p class='badge badge-info'>{$department}</p><br>{$degreesHtml}";
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
                    <a href='{$editUrl}' class='btn btn-icon btn-bg-info btn-sm me-2'><i class='fas fa-edit text-white'></i></a>
                    <a href='{$viewUrl}' class='btn btn-icon btn-bg-light btn-sm viewDoctorBtn'><i class='fas fa-eye text-dark'></i></a>
                </div>";
            })
            ->rawColumns(['photo', 'info', 'contact_info', 'action'])
            ->make(true);
    }

    public function storeDoctor(DoctorRequest $request): Model
    {
        DB::beginTransaction();
        try {
            $doctorData = $request->fields();
            $degreeData = [];

            if (!empty($request->photo)) {
                $doctorData['photo'] = $this->uploadMedia($request, 'photo', 'doctor');
            }

            $doctorData['password'] = Hash::make($doctorData['password']);

            $doctor = Doctor::query()->create($doctorData);

            if (!empty($doctorData['degree_title'])) {
                // Loop through the product items
                foreach ($doctorData['degree_title'] as $index => $degreeTitle) {
                    $degreeData[] = [
                        'doctor_id' => $doctor->doctor_id,
                        'degree_title' => $degreeTitle,
                        'degree_description' => $doctorData['degree_description'][$index],
                        'created_by' => loggedInUserId(),
                        'created_at' => createdAtDateConvertToDB(),
                    ];
                }
                // dd($paymentScheduleData);
                if (!empty($degreeData)) {
                    DoctorDegree::query()->insert($degreeData);
                }
            }
            DB::commit();

            return $doctor;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function getDoctorForEditById(int $doctorId): Model|Builder
    {
        return Doctor::with('department', 'degrees')->find($doctorId);
    }

    public function getDoctorById(int $doctorId): Model|Builder
    {
        return Doctor::query()->where('doctor_id', $doctorId)->first();
    }

    public function updateDoctor(DoctorRequest $request, int $doctorId): Model
    {
        DB::beginTransaction();
        try {
            $doctorData = $request->fields();
            $doctorDegree = [];
            // dd($doctorData);

            $doctorInfo = $this->getDoctorById($doctorId);

            if (!empty($request->photo)) {
                $doctorData['photo'] = $this->updateMedia($request, 'photo', 'doctor', $doctorInfo['photo']);
            }

            if (!empty($doctorData['degree_title'])) {

                DoctorDegree::where('doctor_id', $doctorId)->delete();

                // Loop through the product items
                foreach ($doctorData['degree_title'] as $index => $degreeTitle) {
                    $degreeData[] = [
                        'doctor_id' => $doctorId,
                        'degree_title' => $degreeTitle,
                        'degree_description' => $doctorData['degree_description'][$index],
                        'created_by' => loggedInUserId(),
                        'created_at' => createdAtDateConvertToDB(),
                    ];
                }
                // dd($paymentScheduleData);
                if (!empty($degreeData)) {
                    DoctorDegree::query()->insert($degreeData);
                }
            }

            $doctorInfo->update($doctorData);
            DB::commit();

            return $doctorInfo;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
