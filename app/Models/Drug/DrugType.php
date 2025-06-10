<?php

namespace App\Models\Drug;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrugType extends Model
{
    use HasFactory;

    protected $primaryKey = 'drug_type_id';

    protected $table = 'drug_types';

    protected $fillable = [
        'drug_type_id',
        'drug_type',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];
}
