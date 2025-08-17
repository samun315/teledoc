<?php

namespace App\Http\Controllers\Doctor;

use App\Constant\Schedule\ScheduleConstant;
use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\DoctorScheduleRequest;
use App\Models\Doctor\Doctor;
use App\Services\Doctor\DoctorScheduleService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
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

    public function create(): View
    {
        $data['days'] = ScheduleConstant::DAYS;
        $data['doctorInfos'] = Doctor::query()->where('status', 'Active')->get(['doctor_id', 'title', 'name']);

        return view('doctor.schedule.create', $data);
    }

    public function getDoctorInfoById(int $doctorId): JsonResponse
    {
        $data = $this->doctorScheduleService->getDoctorInfoById($doctorId);
        return sendSuccessResponse(200, '', 'data', $data);
    }


    public function store(DoctorScheduleRequest $request): RedirectResponse
    {
        try {

            $this->doctorScheduleService->createDoctorSchedule($request->fields());
            return to_route('schedule.index')->with('success', 'Schedule created successfully!');
        } catch (Exception $e) {
            return back()->with('general', $e->getMessage());
        }
    }

    public function edit(int $scheduleId): View
    {
        $data['editModeData'] = $this->doctorScheduleService->getScheduleById($scheduleId);

        $data['days'] = ScheduleConstant::DAYS;

        $data['doctorInfos'] = Doctor::query()->where('status', 'Active')->get(['doctor_id', 'title', 'name']);

        return view('doctor.schedule.edit', $data);
    }

    public function update(DoctorScheduleRequest $request, int $scheduleId): RedirectResponse
    {
        try {

            $this->doctorScheduleService->updateSchedule($request->fields(), $scheduleId);
            return to_route('schedule.index')->with('success', 'Schedule updated successfully!');
        } catch (Exception $e) {
            return back()->with('general', $e->getMessage());
        }
    }
}
