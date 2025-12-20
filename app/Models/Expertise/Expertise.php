<?php

namespace App\Models\Expertise;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expertise extends Model
{
    use HasFactory;

    protected $primaryKey = 'expertise_id';
    protected $table = 'expertise_sections';

    protected $fillable = [
        'expertise_id',
        'title',
        'image',
        'item_1_icon',
        'item_1_title',
        'item_1_description',
        'item_1_link',
        'item_2_icon',
        'item_2_title',
        'item_2_description',
        'item_2_link',
        'item_3_icon',
        'item_3_title',
        'item_3_description',
        'item_3_link',
        'item_4_icon',
        'item_4_title',
        'item_4_description',
        'item_4_link',
        'status',
    ];
}

