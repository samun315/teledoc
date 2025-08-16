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

class DoctorScheduleService
{
    public function getScheduleList(Request $request): JsonResponse|Model|Builder
    {
        $searchKeyword = $request->input('search');

        $query = DoctorSchedule::query()
            ->leftJoin('doctors', 'doctor_weekly_schedule.doctor_id', '=', 'doctors.doctor_id')
            ->leftJoin('departments', 'doctors.department_id', '=', 'departments.department_id')
            ->select('doctor_weekly_schedule.*', 'doctors.title', 'doctors.name', 'doctors.phone', 'departments.department_name')->latest();

        if ($searchKeyword) {
            $query->where('doctors.name', 'like', '%' . $searchKeyword . '%');
        }

        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('contact_info', function ($row) {
                $title = e($row->title);
                $name = e($row->name);

                $department = e($row->department_name);
                $phone = e($row->phone);

                return "<i class='fas fa-user text-primary'></i> : {$title} {$name}<br>
                <i class='fas fa-phone text-dark'></i> : {$phone}<br>
                <p class='badge badge-info'>{$department}</p>";
            })
            ->addColumn('days', function ($row) {
                $dayOfWeek = e($row->day_of_week);
                $startTime = Carbon::parse($row->start_time)->format('h:i A');
                $endTime   = Carbon::parse($row->end_time)->format('h:i A');

                $minutes = (int) $row->slot_duration_minutes;

                // Format slot duration into hours/minutes text
                if ($minutes < 60) {
                    $slotTimeText = "{$minutes} minutes";
                } else {
                    $hours   = floor($minutes / 60);
                    $mins    = $minutes % 60;
                    $slotTimeText = $hours . ' hour' . ($hours > 1 ? 's' : '');
                    if ($mins > 0) {
                        $slotTimeText .= " {$mins} minutes";
                    }
                }

                return "<strong>Day: {$dayOfWeek} <br> Start Time: <span class='text-primary'> {$startTime}</span> <br> End Time: <span class='text-danger'> {$endTime}</span><br> Slot Time: <span class='text-success'> {$slotTimeText}</span></strong>";
            })

            ->addColumn('action', function ($row) {

                $editBtn = '<a href="' . route('schedule.edit', $row->schedule_id) . '" class="btn btn-info text-white btn-sm">Edit</a>';

                $button = '<div class="btn-group" role="group" aria-label="Basic example">
                            ' . $editBtn . '
                            </div>';
                return $button;
            })
            ->rawColumns(['contact_info', 'days', 'action'])
            ->make(true);
    }

    public function createDoctorSchedule(array $data): Model|Builder|bool
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

    public function getScheduleById(int $scheduleId): Model|Builder
    {
        return DoctorSchedule::query()->with('doctor.department')->find($scheduleId);
    }

    public function updateSchedule(array $updateData, int $scheduleId): int
    {
        $schedule = $this->getScheduleById($scheduleId);

        // overlap check
        if (!empty($updateData['day_of_week'])) {
            foreach ($updateData['day_of_week'] as $index => $dayOfWeek) {

                $startTime = $updateData['start_time'][$index]; // already 24-hour format
                $endTime   = $updateData['end_time'][$index];

                // Check for overlap with existing schedules
                $overlapExists = DoctorSchedule::query()
                    ->where('doctor_id', $updateData['doctor_id'])
                    ->where('day_of_week', $dayOfWeek)
                    ->where('schedule_id', '!=', $scheduleId) // নিজেরটা বাদ দিব
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
                    throw new Exception("Schedule conflicted with schedule time range.");
                }

                $schedule->update([
                    'day_of_week' => $dayOfWeek,
                    'start_time' => $updateData['start_time'][$index],
                    'end_time' => $updateData['end_time'][$index],
                    'slot_duration_minutes' => $updateData['slot_duration_minutes'][$index],
                    'updated_by' => $updateData['updated_by'],
                    'updated_at' => $updateData['updated_at'],
                ]);
            }
        }

        return $scheduleId;
    }
}
