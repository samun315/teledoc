<?php

namespace App\Models\Doctor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $primaryKey = 'doctor_id';

    protected $table = 'doctors';

    protected $fillable = [
        'doctor_id',
        'title',
        'name',
        'department_id',
        'phone',
        'email',
        'address',
        'description',
        'photo',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    public function department()
    {
        return $this->belongsTo(DoctorDepartment::class, 'department_id');
    }

    public function degrees()
    {
        return $this->hasMany(DoctorDegree::class, 'doctor_id');
    }
}
