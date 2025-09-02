<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    use HasFactory;

    protected $primaryKey = 'blog_category_id';

    protected $table = 'blog_categories';

    protected $fillable = [
        'blog_category_id',
        'category_name',
        'description',
        'slug',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];
}
