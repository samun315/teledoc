<?php

namespace App\Services\Expertise;

use App\Models\Expertise\Expertise;
use App\Services\Media\ImageOptimizer;

class ExpertiseService
{
    /**
     * Get or create single expertise section
     */
    public function getOrCreateExpertiseSection()
    {
        $expertise = Expertise::first();
        if (!$expertise) {
            $expertise = Expertise::create([
                'title' => 'Our Expertise',
                'status' => 'Active',
            ]);
        }
        return $expertise;
    }

    /**
     * Get active expertise section for frontend
     */
    public function getActiveExpertiseSection()
    {
        return Expertise::where('status', 'Active')->first();
    }

    /**
     * Update the expertise section (single record)
     */
    public function updateExpertiseSection($data)
    {
        $expertise = Expertise::first();
        
        if (!$expertise) {
            $expertise = Expertise::create([
                'title' => $data['title'] ?? 'Our Expertise',
                'status' => $data['status'] ?? 'Active',
            ]);
        }

        // Handle image upload
        if (isset($data['image']) && $data['image']) {
            // Delete old image if exists
            if ($expertise->image) {
                $this->deleteImage($expertise->image);
            }
            $data['image'] = $this->uploadImage($data['image']);
        }

        $expertise->update($data);

        return $expertise;
    }

    /**
     * Upload image to storage
     */
    private function uploadImage($image)
    {
        return app(ImageOptimizer::class)->storeOnDisk($image, 'expertise', 'expertise');
    }

    /**
     * Delete image from storage
     */
    private function deleteImage($imagePath)
    {
        app(ImageOptimizer::class)->delete($imagePath);
    }
}

