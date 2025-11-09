<?php

namespace App\Services\Service;

use App\Models\Service\Service;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceService
{
    /**
     * Get all services
     */
    public function getAllServices()
    {
        return Service::orderBy('order', 'asc')->get();
    }

    /**
     * Get active services for frontend
     */
    public function getActiveServices()
    {
        return Service::where('status', 'Active')
            ->orderBy('order', 'asc')
            ->get();
    }

    /**
     * Get a specific service by ID
     */
    public function getServiceById($id)
    {
        return Service::findOrFail($id);
    }

    /**
     * Get a specific service by slug
     */
    public function getServiceBySlug($slug)
    {
        return Service::where('slug', $slug)
            ->where('status', 'Active')
            ->firstOrFail();
    }

    /**
     * Create a new service
     */
    public function createService($data)
    {
        $data['slug'] = $this->generateUniqueSlug($data['title']);

        // Handle banner image upload
        if (isset($data['banner_image']) && $data['banner_image']) {
            $data['banner_image'] = $this->uploadImage($data['banner_image'], 'banner');
        }

        // Handle detail image upload
        if (isset($data['detail_image']) && $data['detail_image']) {
            $data['detail_image'] = $this->uploadImage($data['detail_image'], 'detail');
        }

        // Set order to last if not provided
        if (!isset($data['order']) || $data['order'] === null) {
            $maxOrder = Service::max('order');
            $data['order'] = $maxOrder ? $maxOrder + 1 : 1;
        }

        return Service::create($data);
    }

    /**
     * Update an existing service
     */
    public function updateService($id, $data)
    {
        $service = Service::findOrFail($id);

        // Only generate new slug if title has changed
        if ($service->title !== $data['title']) {
            $data['slug'] = $this->generateUniqueSlug($data['title'], $id);
        }

        // Handle banner image upload
        if (isset($data['banner_image']) && $data['banner_image']) {
            // Delete old image if exists
            if ($service->banner_image) {
                $this->deleteImage($service->banner_image);
            }
            $data['banner_image'] = $this->uploadImage($data['banner_image'], 'banner');
        }

        // Handle detail image upload
        if (isset($data['detail_image']) && $data['detail_image']) {
            // Delete old image if exists
            if ($service->detail_image) {
                $this->deleteImage($service->detail_image);
            }
            $data['detail_image'] = $this->uploadImage($data['detail_image'], 'detail');
        }

        $service->update($data);

        return $service;
    }

    /**
     * Delete a service
     */
    public function deleteService($id)
    {
        $service = Service::findOrFail($id);

        // Delete banner image if exists
        if ($service->banner_image) {
            $this->deleteImage($service->banner_image);
        }

        // Delete detail image if exists
        if ($service->detail_image) {
            $this->deleteImage($service->detail_image);
        }

        return $service->delete();
    }

    /**
     * Generate unique slug for service
     */
    private function generateUniqueSlug($title, $excludeId = null)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        // Check if slug exists, excluding current service if updating
        $query = Service::where('slug', $slug);
        if ($excludeId) {
            $query->where('service_id', '!=', $excludeId);
        }

        while ($query->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $query = Service::where('slug', $slug);
            if ($excludeId) {
                $query->where('service_id', '!=', $excludeId);
            }
            $counter++;
        }

        return $slug;
    }

    /**
     * Upload image to storage
     */
    private function uploadImage($image, $type = 'banner')
    {
        $filename = time() . '_' . $type . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
        $path = $image->storeAs('services', $filename, 'public');
        return $path;
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

