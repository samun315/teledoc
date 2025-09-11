<?php

namespace App\Models\Doctor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DoctorAppointment extends Model
{
    use HasFactory;

    protected $primaryKey = 'appointment_id';

    protected $table = 'doctor_weekly_schedule';

    protected $fillable = [
        'appointment_id',
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

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class,'doctor_id','doctor_id');
    }
}
