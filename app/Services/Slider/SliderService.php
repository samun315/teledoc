<?php

namespace App\Services\Slider;

use App\Models\Slider\Slider;
use App\Services\Media\ImageOptimizer;

class SliderService
{
    /**
     * Get all sliders
     */
    public function getAllSliders()
    {
        return Slider::orderBy('order', 'asc')->get();
    }

    /**
     * Get active sliders for frontend
     */
    public function getActiveSliders()
    {
        return Slider::where('status', 'Active')
            ->orderBy('order', 'asc')
            ->get();
    }

    /**
     * Get a specific slider by ID
     */
    public function getSliderById($id)
    {
        return Slider::findOrFail($id);
    }

    /**
     * Create a new slider
     */
    public function createSlider($data)
    {
        // Handle background image upload
        if (isset($data['image']) && $data['image']) {
            $data['image'] = $this->uploadImage($data['image'], 'background');
        }

        // Handle shape image upload
        if (isset($data['shape_image']) && $data['shape_image']) {
            $data['shape_image'] = $this->uploadImage($data['shape_image'], 'shape');
        }

        // Set order to last if not provided
        if (!isset($data['order']) || $data['order'] === null) {
            $maxOrder = Slider::max('order');
            $data['order'] = $maxOrder ? $maxOrder + 1 : 1;
        }

        return Slider::create($data);
    }

    /**
     * Update an existing slider
     */
    public function updateSlider($id, $data)
    {
        $slider = Slider::findOrFail($id);

        // Handle background image upload
        if (isset($data['image']) && $data['image']) {
            // Delete old image if exists
            if ($slider->image) {
                $this->deleteImage($slider->image);
            }
            $data['image'] = $this->uploadImage($data['image'], 'background');
        }

        // Handle shape image upload
        if (isset($data['shape_image']) && $data['shape_image']) {
            // Delete old shape image if exists
            if ($slider->shape_image) {
                $this->deleteImage($slider->shape_image);
            }
            $data['shape_image'] = $this->uploadImage($data['shape_image'], 'shape');
        }

        $slider->update($data);

        return $slider;
    }

    /**
     * Delete a slider
     */
    public function deleteSlider($id)
    {
        $slider = Slider::findOrFail($id);

        // Delete background image if exists
        if ($slider->image) {
            $this->deleteImage($slider->image);
        }

        // Delete shape image if exists
        if ($slider->shape_image) {
            $this->deleteImage($slider->shape_image);
        }

        return $slider->delete();
    }

    /**
     * Upload image to storage
     */
    private function uploadImage($image, $type = 'background')
    {
        return app(ImageOptimizer::class)->storeOnDisk($image, 'sliders', $type);
    }

    /**
     * Delete image from storage
     */
    private function deleteImage($imagePath)
    {
        app(ImageOptimizer::class)->delete($imagePath);
    }
}

