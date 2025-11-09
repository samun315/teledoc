<?php

namespace App\Models\Testimonial;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $primaryKey = 'testimonial_id';
    protected $table = 'testimonials';

    protected $fillable = [
        'testimonial_id',
        'patient_name',
        'patient_designation',
        'patient_image',
        'testimonial_text',
        'rating',
        'order',
        'status',
        'is_featured',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];
}

