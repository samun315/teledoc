<?php

namespace App\Models\Doctor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorDegree extends Model
{
    use HasFactory;

    protected $primaryKey = 'degree_id';

    protected $table = 'doctor_degrees';

    protected $fillable = [
        'degree_id',
        'doctor_id',
        'degree_title',
        'degree_description',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];
}
