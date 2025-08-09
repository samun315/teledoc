<?php

namespace App\Models\Drug;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrescriptionMedication extends Model
{
    use HasFactory;

    protected $primaryKey = 'prescription_medication_id';

    protected $table = 'prescription_medications';

    protected $fillable = [
        'prescription_medication_id',
        'prescription_id',
        'drug_type_id',
        'drug_id',
        'drug_strength_id',
        'drug_duration_id',
        'drug_dose_id',
        'drug_advice_id',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];
}
