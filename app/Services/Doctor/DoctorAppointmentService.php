<?php

namespace App\Services\Doctor;

use App\Models\Doctor\Doctor;
use App\Models\Doctor\DoctorSchedule;
use App\Models\Drug\DrugType;
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
        $query = DoctorSchedule::query()
            ->leftJoin('doctors', 'doctor_weekly_schedule.doctor_id', '=', 'doctors.doctor_id')
            ->leftJoin('departments', 'doctors.department_id', '=', 'departments.department_id')
            ->select(
                'doctor_weekly_schedule.doctor_id',
                'doctors.title',
                'doctors.name',
                'doctors.phone',
                'departments.department_name',
                DB::raw("GROUP_CONCAT(DISTINCT doctor_weekly_schedule.day_of_week ORDER BY FIELD(doctor_weekly_schedule.day_of_week,'Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday')) as days"),
                DB::raw("GROUP_CONCAT(
            CONCAT(
                doctor_weekly_schedule.day_of_week, '||',
                doctor_weekly_schedule.start_time, '||',
                doctor_weekly_schedule.end_time, '||',
                doctor_weekly_schedule.slot_duration_minutes
            ) ORDER BY doctor_weekly_schedule.schedule_id ASC SEPARATOR ';;'
        ) as schedule_details")
            )
            ->groupBy(
                'doctor_weekly_schedule.doctor_id',
                'doctors.title',
                'doctors.name',
                'doctors.phone',
                'departments.department_name'
            );

        if ($searchKeyword) {
            $query->where('doctors.name', 'like', '%' . $searchKeyword . '%');
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('contact_info', function ($row) {
                return "
            <i class='fas fa-user text-primary'></i> : {$row->title} {$row->name}<br>
            <i class='fas fa-phone text-dark'></i> : {$row->phone}<br>
            <p class='badge badge-info'>{$row->department_name}</p>
        ";
            })
            ->addColumn('days', function ($row) {
                $days = explode(',', $row->days ?? '');
                $badges = '';
                foreach ($days as $d) {
                    $badges .= "<span class='badge badge-light-info me-1'>{$d}</span>";
                }
                return $badges;
            })
            ->addColumn('action', function ($row) {
                $editBtn = '<a href="' . route('schedule.edit', $row->doctor_id) . '" class="btn btn-info text-white btn-sm">Edit</a>';

                $detailsBtn = '<button 
            class="btn btn-primary btn-sm showDetailsBtn ms-2" 
            data-schedules="' . e($row->schedule_details) . '"
            data-doctor="' . e($row->title . ' ' . $row->name) . '"
        >Details</button>';

                return '<div class="btn-group" role="group">' . $editBtn . $detailsBtn . '</div>';
            })
            ->rawColumns(['contact_info', 'days', 'action'])
            ->make(true);
    }


    public function createDoctorAppointment(array $data): Model|Builder|bool
    {
        DB::beginTransaction();
        try {
            $makeScheduleData = [];

            if (!empty($data['day_of_week'])) {
                foreach ($data['day_of_week'] as $index => $dayOfWeek) {

                    $startTime = $data['start_time'][$index]; // already 24-hour format
                    $endTime   = $data['end_time'][$index];

                    // Check for overlap with existing schedules
                    $overlapExists = DoctorSchedule::query()
                        ->where('doctor_id', $data['doctor_id'])
                        ->where('day_of_week', $dayOfWeek)
                        ->where(function ($query) use ($startTime, $endTime) {
                            $query->whereBetween('start_time', [$startTime, $endTime])
                                ->orWhereBetween('end_time', [$startTime, $endTime])
                                ->orWhere(function ($q) use ($startTime, $endTime) {
                                    $q->where('start_time', '<=', $startTime)
                                        ->where('end_time', '>=', $endTime);
                                });
                        })
                        ->exists();

                    if ($overlapExists) {
                        throw new Exception("Schedule already created for {$dayOfWeek} at {$startTime} - {$endTime}");
                    }

                    $makeScheduleData[$index] = [
                        'doctor_id' => $data['doctor_id'],
                        'day_of_week' => $dayOfWeek,
                        'start_time' => $startTime,
                        'end_time' => $endTime,
                        'slot_duration_minutes' => $data['slot_duration_minutes'][$index],
                        'created_by' => loggedInUserId(),
                        'created_at' => createdAtDateConvertToDB(),
                    ];
                }
            }

            $schedule = DoctorSchedule::query()->insert($makeScheduleData);
            DB::commit();

            return $schedule;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }


    public function getDoctorInfoById(int $doctorId): Model|Builder
    {
        return Doctor::query()->with('department')->find($doctorId);
    }

    public function getAppointmentByDoctorId(int $doctorId): Model|Builder|Collection
    {
        return DoctorSchedule::query()->with('doctor.department')->where('doctor_id', $doctorId)->get();
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
