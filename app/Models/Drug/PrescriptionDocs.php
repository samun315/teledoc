<?php

namespace App\Models\Drug;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrescriptionDocs extends Model
{
    use HasFactory;

    protected $primaryKey = 'doc_id';

    protected $table = 'prescription_docs';

    protected $fillable = [
        'doc_id',
        'prescription_id',
        'patient_id',
        'attachment',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];
}
