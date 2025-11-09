<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $primaryKey = 'service_id';
    protected $table = 'services';

    protected $fillable = [
        'service_id',
        'title',
        'slug',
        'icon',
        'short_description',
        'content',
        'banner_image',
        'detail_image',
        'order',
        'status',
        'meta_description',
    ];
}

