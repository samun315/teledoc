<?php

namespace App\Services\Doctor;

use App\Models\Doctor\Doctor;
use App\Models\Doctor\DoctorAppointment;
use App\Models\Doctor\DoctorSchedule;
use App\Models\Drug\DrugType;
use App\Models\Patient\Patient;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class DoctorAppointmentService
{
    public function getAppointmentList(Request $request): JsonResponse|Model|Builder
    {
        $searchKeyword = $request->input('search');
        $query = DoctorAppointment::query()
            ->leftJoin('doctors', 'appointments.doctor_id', '=', 'doctors.doctor_id')
            ->leftJoin('departments', 'doctors.department_id', '=', 'departments.department_id')
            ->leftJoin('patients', 'appointments.patient_id', '=', 'patients.patient_id')
            ->select(
                'appointments.*',
                'patients.name as patient_name',
                'patients.email as patient_email',
                'patients.phone as patient_phone',
                'patients.date_of_birth as patient_dob',
                'patients.photo as patient_photo',
                'patients.gender as patient_gender',
                'patients.blood_group as patient_blood_group',
                'patients.marital_status as patient_marital_status',
                'doctors.name as doctor_name',
                'doctors.title as doctor_title',
                'doctors.phone as doctor_phone',
                'departments.department_name',
            )->latest();

        if ($searchKeyword) {
            $query->where('patients.name', 'like', '%' . $searchKeyword . '%')
                ->orWhere('appointments.appointment_status', 'like', '%' . $searchKeyword . '%')
                ->orWhere('doctors.name', 'like', '%' . $searchKeyword . '%');
        }


        // $query->orderBy('orders');

        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('date_of_appointment', function ($row) {
                if (!$row->appointment_date || !$row->slot_time) {
                    return '-';
                }

                // Convert slot_time to 12-hour format with AM/PM
                $slotTime = Carbon::createFromFormat('H:i', $row->slot_time)->format('h:i A');

                // Wrap slot time in a badge
                $slotBadge = '<span class="badge bg-success ms-2">' . $slotTime . '</span>';

                // Concatenate appointment_date and slot badge
                return '<strong>' . $row->appointment_date . '</strong> ' . $slotBadge;
            })
            ->addColumn('doctor_info', function ($row) {
                return "
                <i class='fas fa-user text-primary'></i> : {$row->doctor_title} {$row->doctor_name}<br>
                <i class='fas fa-phone text-dark'></i> : {$row->doctor_phone}<br>
                <p class='badge badge-info'>{$row->department_name}</p>
                ";
            })
            ->addColumn('patient_info', function ($row) {
                $photoPath = !empty($row->patient_photo)
                    ? 'uploads/patient/' . $row->patient_photo
                    : 'assets/media/avatars/blank.png';

                $photo = '<img src="' . $photoPath . '" alt="Patient" class="rounded-circle me-2" width="60" height="60">';

                $name = $row->patient_name ?? '';
                $gender = $row->patient_gender ?? '';
                $blood_group = $row->patient_blood_group ?? '';
                $marital_status = $row->patient_marital_status ?? '';
                $dob = $row->patient_dob ?? '';
                $email = $row->patient_email ?? '';
                $phone = $row->patient_phone ?? '';

                $info = '
                    <div class="d-flex align-items-start">
                        <div class="me-3">
                            ' . $photo . '
                        </div>
                        <div>
                            <div><i class="fas fa-venus-mars text-danger"></i> :' . $gender . ',
                            <i class="fas fa-tint text-danger ms-1"></i> :' . $blood_group . '</div>
                            <div><i class="fas fa-ring text-warning"></i> :' . $marital_status . '</div>
                            <div><i class="fas fa-calendar-day text-success"></i> :' . $dob . '</div>
                            <div><i class="fas fa-envelope text-primary"></i> :' . $email . '</div>
                            <div><i class="fas fa-phone text-dark"></i> :' . $phone . '</div>
                        </div>
                    </div>';

                return $info;
            })
            ->addColumn('action', function ($row) {

                $editBtn = '<a href="' . route('appointment.edit', $row->appointment_id) . '" class="btn btn-icon btn-bg-info text-white btn-sm"><i class="fas fa-edit text-white"></i></a>';

                $button = '<div class="btn-group" role="group" aria-label="Basic example">
                            ' . $editBtn . '
                            </div>';
                return $button;
            })
            ->rawColumns(['date_of_appointment','doctor_info', 'patient_info', 'action'])
            ->make(true);
    }

    public function createDoctorAppointment(array $data): Model|Builder
    {
        DB::beginTransaction();

        try {
            // 1. Doctor-slot-date overlap check
            $doctorSlotExists = DoctorAppointment::query()
                ->where('doctor_id', $data['doctor_id'])
                ->where('appointment_date', $data['appointment_date'])
                ->where('slot_id', $data['slot_id'])
                ->exists();

            if ($doctorSlotExists) {
                throw new Exception("This slot is already booked for the selected doctor on {$data['appointment_date']}.");
            }

            // 2. Patient already booked same date check
            $patientExists = DoctorAppointment::query()
                ->where('patient_id', $data['patient_id'])
                ->where('appointment_date', $data['appointment_date'])
                ->exists();

            if ($patientExists) {
                throw new Exception("This patient already has an appointment on {$data['appointment_date']}.");
            }

            $data['appointment_code'] = $this->generateAppointmentCode('appointments');
            // Create appointment
            $appointment = DoctorAppointment::query()->create([
                'doctor_id'        => $data['doctor_id'],
                'patient_id'       => $data['patient_id'],
                'appointment_code' => $data['appointment_code'],
                'appointment_date' => $data['appointment_date'],
                'slot_id'          => $data['slot_id'],
                'slot_time'        => $data['slot_time'],
                'created_by'       => $data['created_by'],
                'created_at'       => $data['created_at'],
            ]);

            DB::commit();

            return $appointment;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function generateAppointmentCode(string $tableName)
    {
        // আজকের তারিখ YYMMDD format
        $date = Carbon::now()->format('ymd'); // e.g., 250914

        // আজকের ticket এর সংখ্যা
        $countToday = DB::table($tableName)
            ->whereDate('created_at', Carbon::today())
            ->count();

        // Incremental number (start from 1 every day)
        $incremental = str_pad($countToday + 1, 3, '0', STR_PAD_LEFT); // 001, 002, ...

        // Final ticket number
        return 'A-' . $date . '-' . $incremental;
    }

    public function getDoctorInfoById(int $doctorId): Model|Builder
    {
        return Doctor::query()->with('department')->find($doctorId);
    }

    public function getPatientInfoById(int $patientId): Model|Builder
    {
        return Patient::query()->find($patientId);
    }

    public function getAppointmentByDoctorId(int $appointmentId): Model|Builder|Collection
    {
        return DoctorAppointment::query()->with('doctor.patient')->where('appointment_id', $appointmentId)->get();
    }

    public function updateAppointment(array $updateData): bool
    {
        $doctorId = $updateData['doctor_id'];

        // 1️⃣ Delete removed schedules
        $existingIds = DoctorSchedule::where('doctor_id', $doctorId)->pluck('schedule_id')->toArray();
        $submittedIds = $updateData['schedule_id'] ?? [];
        $toDelete = array_diff($existingIds, $submittedIds);
        if (!empty($toDelete)) {
            DoctorSchedule::whereIn('schedule_id', $toDelete)->delete();
        }

        // 2️⃣ Update/Create schedules
        foreach ($updateData['day_of_week'] as $index => $dayOfWeek) {
            $startTime = $updateData['start_time'][$index];
            $endTime   = $updateData['end_time'][$index];
            $slotDuration = $updateData['slot_duration_minutes'][$index];

            // Overlap check
            $query = DoctorSchedule::query()
                ->where('doctor_id', $doctorId)
                ->where('day_of_week', $dayOfWeek);

            if (!empty($updateData['schedule_id'][$index])) {
                $scheduleId = $updateData['schedule_id'][$index];
                $query->where('schedule_id', '!=', $scheduleId);
            }

            $overlapExists = $query->where(function ($q) use ($startTime, $endTime) {
                $q->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime])
                    ->orWhere(function ($qq) use ($startTime, $endTime) {
                        $qq->where('start_time', '<=', $startTime)
                            ->where('end_time', '>=', $endTime);
                    });
            })->exists();

            if ($overlapExists) {
                throw new Exception("Schedule conflicted with schedule time range for $dayOfWeek.");
            }

            // Update or Create
            if (!empty($updateData['schedule_id'][$index])) {
                DoctorSchedule::where('schedule_id', $updateData['schedule_id'][$index])->update([
                    'day_of_week' => $dayOfWeek,
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                    'slot_duration_minutes' => $slotDuration,
                    'updated_by' => $updateData['updated_by'],
                    'updated_at' => $updateData['updated_at'],
                ]);
            } else {
                DoctorSchedule::create([
                    'doctor_id' => $doctorId,
                    'day_of_week' => $dayOfWeek,
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                    'slot_duration_minutes' => $slotDuration,
                    'created_by' => $updateData['created_by'],
                    'updated_by' =>  $updateData['updated_by'],
                    'created_at' => $updateData['created_at'],
                    'updated_at' => $updateData['updated_at'],
                ]);
            }
        }

        return true;
    }
}
