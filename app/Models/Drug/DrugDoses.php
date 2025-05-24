<?php

namespace App\Models\Drug;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DrugDoses extends Model
{
    use HasFactory;

    protected $primaryKey = 'drug_dose_id';

    protected $table = 'drug_doses';

    protected $fillable = [
        'drug_dose_id',
        'drug_type_id',
        'drug_dose',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];
}
