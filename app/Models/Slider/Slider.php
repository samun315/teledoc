<?php

namespace App\Models\Slider;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $primaryKey = 'slider_id';
    protected $table = 'sliders';

    protected $fillable = [
        'slider_id',
        'title',
        'subtitle',
        'image',
        'shape_image',
        'button_text_1',
        'button_url_1',
        'button_text_2',
        'button_url_2',
        'order',
        'status',
    ];
}

