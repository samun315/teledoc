<?php

namespace App\Services\Doctor;

use App\Models\Doctor\DoctorDepartment;
use App\Models\Drug\DrugType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class DoctorDepartmentService
{
    public function getDepartmentList(Request $request): JsonResponse|Model|Builder
    {
        $searchKeyword = $request->input('search');

        $query = DoctorDepartment::query()->select('department_id', 'department_name', 'description', 'status')->latest();

        if ($searchKeyword) {
            $query->where('department_name', 'like', '%' . $searchKeyword . '%')
                ->orWhere('status', 'like', '%' . $searchKeyword . '%');
        }

        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {

                $editBtn = '<button data-id="' . $row?->department_id . '" class="btn btn-bg-info text-white btn-sm editDepartmentBtn" data-bs-toggle="modal" data-bs-target="#showModal">Edit</button>';

                $button = '<div class="btn-group" role="group" aria-label="Basic example">
                            ' . $editBtn . '
                            </div>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function createDepartment(array $data): Model|Builder|bool
    {
        DB::beginTransaction();
        try {

            $department = DoctorDepartment::query()->create($data);
            DB::commit();

            return $department;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function getDepartmentById(int $departmentId): Model|Builder
    {
        return DoctorDepartment::find($departmentId);
    }

    public function updateDepartment(array $updateData, int $departmentId): int
    {
        $department = $this->getDepartmentById($departmentId);

        return $department->update($updateData);
    }
}
