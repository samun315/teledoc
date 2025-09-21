<?php

namespace App\Models\Doctor;

use App\Models\Patient\Patient;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DoctorAppointment extends Model
{
    use HasFactory;

    protected $primaryKey = 'appointment_id';

    protected $table = 'appointments';

    protected $fillable = [
        'appointment_id',
        'doctor_id',
        'patient_id',
        'appointment_code',
        'slot_time',
        'payment_status',
        'appointment_status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'doctor_id');
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
