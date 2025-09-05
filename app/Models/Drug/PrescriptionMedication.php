<?php

namespace App\Models\Drug;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function drugType(): HasOne
    {
        return $this->hasOne(DrugType::class, 'drug_type_id', 'drug_type_id');
    }

    public function drug(): HasOne
    {
        return $this->hasOne(Drug::class, 'drug_id', 'drug_id');
    }

    public function drugStrength(): HasOne
    {
        return $this->hasOne(DrugStrength::class, 'drug_strength_id');
    }

    public function drugDuration(): HasOne
    {
        return $this->hasOne(DrugDuration::class, 'drug_duration_id', 'drug_duration_id');
    }

    public function drugDose(): HasOne
    {
        return $this->hasOne(DrugDoses::class, 'drug_dose_id', 'drug_dose_id');
    }

    public function drugAdvice(): HasOne
    {
        return $this->hasOne(DrugAdvice::class, 'drug_advice_id', 'drug_advice_id');
    }
}
