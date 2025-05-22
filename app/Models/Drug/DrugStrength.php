<?php

namespace App\Models\Drug;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrugStrength extends Model
{
    use HasFactory;

    protected $primaryKey = 'drug_strength_id';

    protected $table = 'drug_strengths';

    protected $fillable = [
        'drug_strength_id',
        'drug_strength',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];
}
