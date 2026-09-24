<?php

namespace App\Services\Blog;

use App\Models\Blog\Blog;
use App\Services\Media\ImageOptimizer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogService
{
    /**
     * Get all blog posts with pagination
     */
    public function getAllBlogs($perPage = 10)
    {
        return Blog::with(['category', 'tags'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get a specific blog post by ID
     */
    public function getBlogById($id)
    {
        return Blog::with(['category', 'tags'])->findOrFail($id);
    }

    /**
     * Create a new blog post
     */
    public function createBlog($data)
    {
        $data['slug'] = $this->generateUniqueSlug($data['title']);

        // Handle featured image upload
        if (isset($data['featured_image']) && $data['featured_image']) {
            $data['banner_image'] = $this->uploadImage($data['featured_image']);
        }

        $blog = Blog::create($data);

        // Attach tags if provided
        if (isset($data['tags']) && is_array($data['tags'])) {
            $blog->tags()->attach($data['tags']);
        }

        return $blog;
    }

    /**
     * Update an existing blog post
     */
    public function updateBlog($id, $data)
    {
        $blog = Blog::findOrFail($id);

        // Only generate new slug if title has changed
        if ($blog->title !== $data['title']) {
            $data['slug'] = $this->generateUniqueSlug($data['title'], $id);
        }

        // Handle featured image upload
        if (isset($data['featured_image']) && $data['featured_image']) {
            // Delete old image if exists
            if ($blog->banner_image) {
                $this->deleteImage($blog->banner_image);
            }
            $data['banner_image'] = $this->uploadImage($data['featured_image']);
        }

        $blog->update($data);

        // Sync tags if provided
        if (isset($data['tags'])) {
            $blog->tags()->sync($data['tags']);
        }

        return $blog;
    }

    /**
     * Delete a blog post
     */
    public function deleteBlog($id)
    {
        $blog = Blog::findOrFail($id);

        // Delete featured image if exists
        if ($blog->banner_image) {
            $this->deleteImage($blog->banner_image);
        }

        // Detach tags
        $blog->tags()->detach();

        return $blog->delete();
    }

    /**
     * Generate unique slug for blog post
     */
    private function generateUniqueSlug($title, $excludeId = null)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        // Check if slug exists, excluding current blog if updating
        $query = Blog::where('slug', $slug);
        if ($excludeId) {
            $query->where('blog_id', '!=', $excludeId);
        }

        while ($query->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $query = Blog::where('slug', $slug);
            if ($excludeId) {
                $query->where('blog_id', '!=', $excludeId);
            }
            $counter++;
        }

        return $slug;
    }

    /**
     * Upload image to storage
     */
    private function uploadImage($image)
    {
        return app(ImageOptimizer::class)->storeOnDisk($image, 'blog/images');
    }

    /**
     * Delete image from storage
     */
    private function deleteImage($imagePath)
    {
        if (Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }
    }

    /**
     * Get published blog posts
     */
    public function getPublishedBlogs($perPage = 10)
    {
        return Blog::with(['category', 'tags'])
            ->where('status', 'Published')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Search blog posts
     */
    public function searchBlogs($query, $perPage = 10)
    {
        return Blog::with(['category', 'tags'])
            ->where('title', 'like', "%{$query}%")
            ->orWhere('content', 'like', "%{$query}%")
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }
}
