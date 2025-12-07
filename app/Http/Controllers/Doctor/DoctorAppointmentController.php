<?php

namespace App\Http\Controllers\Doctor;

use App\Constant\Schedule\ScheduleConstant;
use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\DoctorAppointmentRequest;
use App\Models\Doctor\Doctor;
use App\Models\Doctor\DoctorAppointment;
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
            return to_route('appointment.index')->with('success', 'Appointment created successfully!');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit(int $appointmentId): View
    {
        $data['editModeData'] = $this->doctorAppointmentService->getAppointmentById($appointmentId);

        $data['doctorInfos'] = Doctor::query()->where('status', 'Active')->get(['doctor_id', 'title', 'name']);
        $data['patientInfos'] = Patient::query()->where('active', 'YES')->get(['patient_id', 'name']);
        // dd($data);
        return view('doctor.appointment.edit', $data);
    }

    public function update(DoctorAppointmentRequest $request, int $appointmentId): RedirectResponse
    {
        try {

            $this->doctorAppointmentService->updateAppointment($request->fields(),$appointmentId);
            return to_route('appointment.index')->with('success', 'Appointment updated successfully!');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
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

        // Get all booked slot IDs for this doctor on this date
        $bookedSlotIds = DoctorAppointment::where('doctor_id', $doctorId)
            ->where('appointment_date', $date)
            ->pluck('slot_id') // get array of booked slot ids
            ->toArray();

        $slots = [];
        $slotId = 1;

        foreach ($schedules as $schedule) {
            $start = Carbon::parse($schedule->start_time);
            $end = Carbon::parse($schedule->end_time);
            $duration = (int) $schedule->slot_duration_minutes;

            while ($start->lt($end)) {
                $slotEnd = (clone $start)->addMinutes($duration);

                if ($slotEnd->lte($end)) {
                    // যদি এই slot booked থাকে, skip
                    if (in_array($slotId, $bookedSlotIds)) {
                        $slotId++;
                        $start->addMinutes($duration);
                        continue;
                    }

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
            'success'   => true,
            'date'      => $date,
            'doctor_id' => $doctorId,
            'slots'     => $slots
        ]);
    }

    public function getPreviousSlot(int $doctorId, string $date, ?int $appointmentId = null): JsonResponse
    {
        $dayOfWeek = Carbon::parse($date)->format('l');

        // ওই দিনের schedule গুলো
        $schedules = DoctorSchedule::where('doctor_id', $doctorId)
            ->where('day_of_week', $dayOfWeek)
            ->where('status', 'Active')
            ->get();

        if ($schedules->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No schedules available',
                'slots'   => []
            ]);
        }

        // ওই date এর সব booked slot id গুলো (edit করা appointment বাদে)
        $bookedSlotIds = DoctorAppointment::where('doctor_id', $doctorId)
            ->where('appointment_date', $date)
            ->when($appointmentId, function ($q) use ($appointmentId) {
                // edited appointment বাদ দিয়ে অন্য সব বুকড slot নেবে
                $q->where('appointment_id', '!=', $appointmentId);
            })
            ->pluck('slot_id')
            ->toArray();

        // selected appointment (doctor + patient + date + appointment id)
        $selectedSlotId   = null;
        $selectedSlotTime = null;

        if ($appointmentId) {
            $appointment = DoctorAppointment::where('appointment_id', $appointmentId)
                ->where('doctor_id', $doctorId)
                ->where('appointment_date', $date)
                ->where('patient_id', request()->get('patient_id')) // ✅ patient check
                ->first();

            if ($appointment) {
                $selectedSlotId   = $appointment->slot_id;
                $selectedSlotTime = $appointment->slot_time;
            }
        }

        // slot generate
        $slots   = [];
        $slotId  = 1;

        foreach ($schedules as $schedule) {
            $start    = Carbon::parse($schedule->start_time);
            $end      = Carbon::parse($schedule->end_time);
            $duration = $schedule->slot_duration_minutes;

            while ($start->lt($end)) {
                $slotEnd = (clone $start)->addMinutes($duration);

                if ($slotEnd->lte($end)) {
                    // check booked (edit করা slot বাদ যাবে না)
                    if (in_array($slotId, $bookedSlotIds)) {
                        $slotId++;
                        $start->addMinutes($duration);
                        continue;
                    }

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
            'success'             => true,
            'doctor_id'           => $doctorId,
            'date'                => $date,
            'slots'               => $slots,
            'selected_slot_id'    => $selectedSlotId,
            'selected_slot_time'  => $selectedSlotTime,
        ]);
    }
}
