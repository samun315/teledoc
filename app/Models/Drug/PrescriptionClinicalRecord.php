<?php

namespace App\Models\Drug;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrescriptionClinicalRecord extends Model
{
    use HasFactory;

    protected $primaryKey = 'prescription_clinical_record_id ';

    protected $table = 'prescription_clinical_records';

    protected $fillable = [
        'prescription_clinical_record_id ',
        'prescription_id',
        'subscription_type_id',
        'subscription_details',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];
}
