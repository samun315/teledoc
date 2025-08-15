<?php

namespace App\Services\Doctor;

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

                return "<strong>Day: {$dayOfWeek} <br> Start Time: {$startTime} <br> End Time: {$endTime}<br> Slot Time: {$slotTimeText}</strong>";
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

    public function createDepartment(array $data): Model|Builder|bool
    {
        DB::beginTransaction();
        try {

            $department = DoctorSchedule::query()->create($data);
            DB::commit();

            return $department;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function getDepartmentById(int $departmentId): Model|Builder
    {
        return DoctorSchedule::find($departmentId);
    }

    public function updateDepartment(array $updateData, int $departmentId): int
    {
        $department = $this->getDepartmentById($departmentId);

        return $department->update($updateData);
    }
}
