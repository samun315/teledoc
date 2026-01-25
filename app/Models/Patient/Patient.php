<?php

namespace App\Models\Patient;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $primaryKey = 'patient_id';

    protected $table = 'patients';

    protected $fillable = [
        'patient_id',
        'patient_id_number',
        'user_id',
        'name',
        'email',
        'phone',
        'password',
        'date_of_birth',
        'age',
        'photo',
        'height',
        'weight',
        'gender',
        'blood_group',
        'marital_status',
        'note',
        'address',
        'active',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];
}
