<?php

namespace App\Models\Drug;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrugDuration extends Model
{
   use HasFactory;

    protected $primaryKey = 'drug_duration_id';

    protected $table = 'drug_durations';

    protected $fillable = [
        'drug_duration_id',
        'drug_duration',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];
}