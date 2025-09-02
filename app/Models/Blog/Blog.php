<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Blog extends Model
{
    use HasFactory;

    protected $primaryKey = 'blog_id';
    protected $table = 'blog_posts';

    protected $fillable = [
        'blog_id',
        'title',
        'slug',
        'content',
        'banner_image',
        'status',
        'category_id',
        'meta_description',
        //'meta_keywords',
        'published_at',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * Get the category that owns the blog post
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    /**
     * Get the tags for the blog post
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(BlogTag::class, 'blog_post_tags', 'blog_id', 'blog_tag_id');
    }
}
