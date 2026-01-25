<?php

namespace App\Models\Doctor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doctor extends Model
{
    use HasFactory;

    protected $primaryKey = 'doctor_id';

    protected $table = 'doctors';

    protected $fillable = [
        'doctor_id',
        'user_id',
        'title',
        'name',
        'department_id',
        'phone',
        'email',
        'address',
        'description',
        'photo',
        'status',
        'consultation_fee',
        'platform_commission',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(DoctorDepartment::class, 'department_id');
    }

    public function degrees(): HasMany
    {
        return $this->hasMany(DoctorDegree::class, 'doctor_id');
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(DoctorSchedule::class, 'doctor_id');
    }
}
