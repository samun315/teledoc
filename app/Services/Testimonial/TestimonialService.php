<?php

namespace App\Services\Testimonial;

use App\Models\Testimonial\Testimonial;
use App\Services\Media\ImageOptimizer;

class TestimonialService
{
    /**
     * Get all testimonials
     */
    public function getAllTestimonials()
    {
        return Testimonial::orderBy('order', 'asc')->get();
    }

    /**
     * Get active testimonials for frontend
     */
    public function getActiveTestimonials()
    {
        return Testimonial::where('status', 'Active')
            ->orderBy('order', 'asc')
            ->get();
    }

    /**
     * Get featured testimonials
     */
    public function getFeaturedTestimonials()
    {
        return Testimonial::where('status', 'Active')
            ->where('is_featured', true)
            ->orderBy('order', 'asc')
            ->get();
    }

    /**
     * Get a specific testimonial by ID
     */
    public function getTestimonialById($id)
    {
        return Testimonial::findOrFail($id);
    }

    /**
     * Create a new testimonial
     */
    public function createTestimonial($data)
    {
        // Handle patient image upload
        if (isset($data['patient_image']) && $data['patient_image']) {
            $data['patient_image'] = $this->uploadImage($data['patient_image']);
        }

        // Set order to last if not provided
        if (!isset($data['order']) || $data['order'] === null) {
            $maxOrder = Testimonial::max('order');
            $data['order'] = $maxOrder ? $maxOrder + 1 : 1;
        }

        // Handle is_featured checkbox
        $data['is_featured'] = isset($data['is_featured']) ? true : false;

        return Testimonial::create($data);
    }

    /**
     * Update an existing testimonial
     */
    public function updateTestimonial($id, $data)
    {
        $testimonial = Testimonial::findOrFail($id);

        // Handle patient image upload
        if (isset($data['patient_image']) && $data['patient_image']) {
            // Delete old image if exists
            if ($testimonial->patient_image) {
                $this->deleteImage($testimonial->patient_image);
            }
            $data['patient_image'] = $this->uploadImage($data['patient_image']);
        }

        // Handle is_featured checkbox
        $data['is_featured'] = isset($data['is_featured']) ? true : false;

        $testimonial->update($data);

        return $testimonial;
    }

    /**
     * Delete a testimonial
     */
    public function deleteTestimonial($id)
    {
        $testimonial = Testimonial::findOrFail($id);

        // Delete patient image if exists
        if ($testimonial->patient_image) {
            $this->deleteImage($testimonial->patient_image);
        }

        return $testimonial->delete();
    }

    /**
     * Toggle status of a testimonial
     */
    public function changeStatus($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->status = $testimonial->status === 'Active' ? 'Inactive' : 'Active';
        $testimonial->save();

        return $testimonial;
    }

    /**
     * Upload image to storage
     */
    private function uploadImage($image)
    {
        return app(ImageOptimizer::class)->storeOnDisk($image, 'testimonials');
    }

    /**
     * Delete image from storage
     */
    private function deleteImage($imagePath)
    {
        app(ImageOptimizer::class)->delete($imagePath);
    }
}

