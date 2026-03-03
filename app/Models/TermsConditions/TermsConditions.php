<?php

namespace App\Models\TermsConditions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermsConditions extends Model
{
    use HasFactory;

    protected $primaryKey = 'terms_conditions_id';
    protected $table = 'terms_conditions';

    protected $fillable = [
        'terms_conditions_id',
        'terms_conditions',
        'created_by',
        'updated_by'
    ];
}
