<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogTag extends Model
{
    use HasFactory;

    protected $primaryKey = 'blog_tag_id';

    protected $table = 'blog_tags';

    protected $fillable = [
        'blog_tag_id',
        'tag_name',
        'description',
        'slug',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];
}
