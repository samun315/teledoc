<?php

namespace App\Services\About;

use App\Models\About\About;
use App\Services\Media\ImageOptimizer;
use Illuminate\Support\Facades\Storage;

class AboutService
{
    /**
     * Get or create single about section
     */
    public function getOrCreateAboutSection()
    {
        $about = About::first();
        if (!$about) {
            $about = About::create([
                'title' => 'About',
                'description' => '',
                'status' => 'Active',
            ]);
        }
        return $about;
    }

    /**
     * Get active about section for frontend
     */
    public function getActiveAboutSection()
    {
        return About::where('status', 'Active')->first();
    }


    /**
     * Update the about section (single record)
     */
    public function updateAboutSection($data)
    {
        $about = About::first();
        
        if (!$about) {
            $about = About::create([
                'title' => $data['title'] ?? 'About',
                'description' => $data['description'] ?? '',
                'status' => $data['status'] ?? 'Active',
            ]);
        }

        // Handle left image upload
        if (isset($data['left_image']) && $data['left_image']) {
            // Delete old image if exists
            if ($about->left_image) {
                $this->deleteImage($about->left_image);
            }
            $data['left_image'] = $this->uploadImage($data['left_image'], 'left');
        }

        // Handle right image upload
        if (isset($data['right_image']) && $data['right_image']) {
            // Delete old image if exists
            if ($about->right_image) {
                $this->deleteImage($about->right_image);
            }
            $data['right_image'] = $this->uploadImage($data['right_image'], 'right');
        }

        $about->update($data);

        return $about;
    }


    /**
     * Upload image to storage
     */
    private function uploadImage($image, $type = 'left')
    {
        return app(ImageOptimizer::class)->storeOnDisk($image, 'about', $type);
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
}

