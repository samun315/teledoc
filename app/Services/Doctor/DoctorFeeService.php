<?php

namespace App\Services\Doctor;

use App\Http\Requests\Doctor\DoctorFeeRequest;
use App\Models\Doctor\Doctor;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class DoctorFeeService
{
    public function getDoctorFeeList(Request $request): JsonResponse
    {
        $searchKeyword = $request->input('search');

        $query = Doctor::with('department')->latest();

        if ($searchKeyword) {
            $query->where(function ($q) use ($searchKeyword) {
                $q->where('title', 'like', "%{$searchKeyword}%")
                    ->orWhere('name', 'like', "%{$searchKeyword}%")
                    ->orWhere('email', 'like', "%{$searchKeyword}%")
                    ->orWhereHas('department', function ($subQuery) use ($searchKeyword) {
                        $subQuery->where('department_name', 'like', "%{$searchKeyword}%");
                    });
            });
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('doctor_info', function ($row) {
                $title = e($row->title);
                $name = e($row->name);
                $department = e($row->department->department_name ?? 'N/A');
                $email = e($row->email);

                return "<strong>{$title} {$name}</strong><br>
                        <span class='badge badge-info'>{$department}</span><br>
                        <small class='text-muted'>{$email}</small>";
            })
            ->addColumn('consultation_fee', function ($row) {
                $fee = $row->consultation_fee ?? 0;
                return '<span class="text-primary fw-bold">' . number_format($fee, 2) . '</span>';
            })
            ->addColumn('platform_commission', function ($row) {
                $commission = $row->platform_commission ?? 0;
                return '<span class="text-success fw-bold">' . number_format($commission, 2) . '%</span>';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('doctor.fee.edit', $row->doctor_id);

                return "<div class='btn-group' role='group'>
                    <a href='{$editUrl}' class='btn btn-icon btn-bg-primary btn-sm me-2' title='Edit Fee'>
                        <i class='fas fa-edit text-white'></i>
                    </a>
                </div>";
            })
            ->rawColumns(['doctor_info', 'consultation_fee', 'platform_commission', 'action'])
            ->make(true);
    }

    public function getDoctorForEditById(int $doctorId): Model|Builder
    {
        return Doctor::with('department')->findOrFail($doctorId);
    }

    public function updateDoctorFee(DoctorFeeRequest $request, int $doctorId): Model
    {
        DB::beginTransaction();
        try {
            $doctor = Doctor::findOrFail($doctorId);
            $feeData = $request->fields();

            $doctor->update($feeData);
            
            DB::commit();

            return $doctor;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
