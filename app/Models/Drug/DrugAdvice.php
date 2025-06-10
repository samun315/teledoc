<?php

namespace App\Models\Drug;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrugAdvice extends Model
{
   use HasFactory;

    protected $primaryKey = 'drug_advice_id';

    protected $table = 'drug_advices';

    protected $fillable = [
        'drug_advice_id',
        'drug_advice',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];
}
