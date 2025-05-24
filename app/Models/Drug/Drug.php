<?php

namespace App\Models\Drug;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
    use HasFactory;

    protected $primaryKey = 'drug_id';

    protected $table = 'drugs';

    protected $fillable = [
        'drug_id',
        'trade_name',
        'generic_name',
        'note',
        'warning',
        'side_effect',
        'additional_advice',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];
}
