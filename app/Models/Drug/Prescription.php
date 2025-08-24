<?php

namespace App\Models\Drug;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function medication(): HasMany
    {
        return $this->hasMany(PrescriptionMedication::class, 'prescription_id','prescription_id');
    }

    public function clinicalRecord(): HasMany
    {
        return $this->hasMany(PrescriptionClinicalRecord::class, 'prescription_id','prescription_id');
    }
}
