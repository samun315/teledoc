<?php

namespace App\Models\Speciality;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Speciality extends Model
{
    use HasFactory;

    protected $primaryKey = 'speciality_id';
    protected $table = 'specialities';

    protected $fillable = [
        'speciality_id',
        'title',
        'slug',
        'description',
        'icon',
        'order',
        'status',
    ];
}

