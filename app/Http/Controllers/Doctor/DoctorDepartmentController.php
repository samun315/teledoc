<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\DoctorDepartmentRequest;
use App\Services\Doctor\DoctorDepartmentService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DoctorDepartmentController extends Controller
{
    public function __construct(protected DoctorDepartmentService $doctorDepartmentService) {}

    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            return $this->doctorDepartmentService->getDepartmentList($request);
        }

        return view('doctor.department.index');
    }

    public function store(DoctorDepartmentRequest $request): JsonResponse
    {
        try {

            $this->doctorDepartmentService->createDepartment($request->fields());
            return sendSuccessResponse(201, 'Department created successfully.');
        } catch (Exception $e) {
            return sendErrorResponse('Internal Server Error: ', $e->getMessage());
        }
    }

    public function edit(int $departmentId): JsonResponse
    {
        $data = $this->doctorDepartmentService->getDepartmentById($departmentId);
        return sendSuccessResponse(200, '', 'departmentInfo', $data);
    }

    public function update(DoctorDepartmentRequest $request, int $departmentId): JsonResponse
    {
        try {

            $this->doctorDepartmentService->updateDepartment($request->fields(), $departmentId);
            return sendSuccessResponse(201, 'Department updated successfully.');
        } catch (Exception $e) {
            return sendErrorResponse('Internal Server Error: ', $e->getMessage());
        }
    }
}
