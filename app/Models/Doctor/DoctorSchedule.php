<?php

namespace App\Models\Doctor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorSchedule extends Model
{
    use HasFactory;

    protected $primaryKey = 'schedule_id';

    protected $table = 'doctor_weekly_schedule';

    protected $fillable = [
        'schedule_id',
        'doctor_id',
        'day_of_week',
        'start_time',
        'end_time',
        'slot_duration_minutes',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];
}
