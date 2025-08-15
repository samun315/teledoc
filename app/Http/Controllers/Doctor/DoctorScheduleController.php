<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\DoctorScheduleRequest;
use App\Models\Doctor\Doctor;
use App\Services\Doctor\DoctorScheduleService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DoctorScheduleController extends Controller
{
    public function __construct(protected DoctorScheduleService $doctorScheduleService) {}

    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            return $this->doctorScheduleService->getScheduleList($request);
        }

        return view('doctor.schedule.index');
    }

    public function create():View
    {
        $data['doctorInfos'] = Doctor::query()->where('status','Active')->get(['doctor_id','title','name']);
       
        return view('doctor.schedule.create',$data);
    }

    public function store(DoctorScheduleRequest $request): JsonResponse
    {
        try {

            $this->doctorScheduleService->createDepartment($request->fields());
            return sendSuccessResponse(201, 'Department created successfully.');
        } catch (Exception $e) {
            return sendErrorResponse('Internal Server Error: ', $e->getMessage());
        }
    }

    public function edit(int $departmentId): JsonResponse
    {
        $data = $this->doctorScheduleService->getDepartmentById($departmentId);
        return sendSuccessResponse(200, '', 'departmentInfo', $data);
    }

    public function update(DoctorScheduleRequest $request, int $departmentId): JsonResponse
    {
        try {

            $this->doctorScheduleService->updateDepartment($request->fields(), $departmentId);
            return sendSuccessResponse(201, 'Department updated successfully.');
        } catch (Exception $e) {
            return sendErrorResponse('Internal Server Error: ', $e->getMessage());
        }
    }
}
