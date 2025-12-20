<?php

namespace App\Models\About;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;

    protected $primaryKey = 'about_id';
    protected $table = 'about_sections';

    protected $fillable = [
        'about_id',
        'title',
        'description',
        'left_image',
        'right_image',
        'feature_1',
        'feature_2',
        'feature_3',
        'button_text',
        'button_link',
        'status',
    ];
}

