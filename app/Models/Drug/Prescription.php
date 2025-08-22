<?php

namespace App\Models\Drug;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    protected $primaryKey = 'prescription_id';

    protected $table = 'prescriptions';

    protected $fillable = [
        'prescription_id',
        'prescription_number',
        'patient_id',
        'doctor_id',
        'appointment_id',
        'status',
        'old_prescription_date',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];
}
