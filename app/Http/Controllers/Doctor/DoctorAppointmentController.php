<?php

namespace App\Http\Controllers\Doctor;

use App\Constant\Schedule\ScheduleConstant;
use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\DoctorAppointmentRequest;
use App\Models\Doctor\Doctor;
use App\Models\Doctor\DoctorSchedule;
use App\Models\Patient\Patient;
use App\Services\Doctor\DoctorAppointmentService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DoctorAppointmentController extends Controller
{
    public function __construct(protected DoctorAppointmentService $doctorAppointmentService) {}

    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            return $this->doctorAppointmentService->getAppointmentList($request);
        }

        return view('doctor.appointment.index');
    }

    public function create(): View
    {
        $data['doctorInfos'] = Doctor::query()->where('status', 'Active')->get(['doctor_id', 'title', 'name']);
        $data['patientInfos'] = Patient::query()->where('active', 'YES')->get(['patient_id', 'name']);

        return view('doctor.appointment.create', $data);
    }

    public function getDoctorInfoById(int $doctorId): JsonResponse
    {
        $data = $this->doctorAppointmentService->getDoctorInfoById($doctorId);
        return sendSuccessResponse(200, '', 'data', $data);
    }
    public function getPatientInfoById(int $patientId): JsonResponse
    {
        $data = $this->doctorAppointmentService->getPatientInfoById($patientId);
        return sendSuccessResponse(200, '', 'data', $data);
    }

    public function store(DoctorAppointmentRequest $request): RedirectResponse
    {
        try {

            $this->doctorAppointmentService->createDoctorAppointment($request->fields());
            return to_route('schedule.index')->with('success', 'Schedule created successfully!');
        } catch (Exception $e) {
            return back()->with('general', $e->getMessage());
        }
    }

    public function edit(int $doctorId): View
    {
        $data['editModeData'] = $this->doctorAppointmentService->getAppointmentByDoctorId($doctorId);

        $data['days'] = ScheduleConstant::DAYS;

        $data['doctorInfo'] = Doctor::query()->with('department')->where('doctor_id', $doctorId)->first();

        return view('doctor.schedule.edit', $data);
    }

    public function update(DoctorAppointmentRequest $request): RedirectResponse
    {
        try {

            $this->doctorAppointmentService->updateAppointment($request->fields());
            return to_route('schedule.index')->with('success', 'Schedule updated successfully!');
        } catch (Exception $e) {
            return back()->with('general', $e->getMessage());
        }
    }

 public function generateDailySlots(int $doctorId, string $date): JsonResponse
{
    $dayOfWeek = Carbon::parse($date)->format('l');

    // Get all schedules for that doctor on the given day
    $schedules = DoctorSchedule::where('doctor_id', $doctorId)
        ->where('day_of_week', $dayOfWeek)
        ->where('status', 'Active')
        ->get();

    if ($schedules->isEmpty()) {
        return response()->json([
            'success' => false,
            'message' => 'No schedules available for this doctor on ' . $dayOfWeek,
            'slots' => []
        ]);
    }

    $slots = [];
    $slotId = 1;

    foreach ($schedules as $schedule) {
        $start = Carbon::parse($schedule->start_time);
        $end = Carbon::parse($schedule->end_time);
        $duration = $schedule->slot_duration_minutes;

        while ($start->lt($end)) {
            $slotEnd = (clone $start)->addMinutes($duration);

            if ($slotEnd->lte($end)) {
                $slots[] = [
                    'slot_id' => $slotId,
                    'start'   => $start->format('H:i'),
                    'end'     => $slotEnd->format('H:i'),
                ];
                $slotId++;
            }

            $start->addMinutes($duration);
        }
    }

    return response()->json([
        'success' => true,
        'date'    => $date,
        'doctor_id' => $doctorId,
        'slots'   => $slots
    ]);
}
}
