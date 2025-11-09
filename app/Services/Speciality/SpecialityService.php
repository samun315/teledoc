<?php

namespace App\Services\Speciality;

use App\Models\Speciality\Speciality;
use Illuminate\Support\Str;

class SpecialityService
{
    /**
     * Get all specialities
     */
    public function getAllSpecialities()
    {
        return Speciality::orderBy('order', 'asc')->get();
    }

    /**
     * Get active specialities for frontend
     */
    public function getActiveSpecialities()
    {
        return Speciality::where('status', 'Active')
            ->orderBy('order', 'asc')
            ->get();
    }

    /**
     * Get a specific speciality by ID
     */
    public function getSpecialityById($id)
    {
        return Speciality::findOrFail($id);
    }

    /**
     * Create a new speciality
     */
    public function createSpeciality($data)
    {
        $data['slug'] = $this->generateUniqueSlug($data['title']);

        // Set order to last if not provided
        if (!isset($data['order']) || $data['order'] === null) {
            $maxOrder = Speciality::max('order');
            $data['order'] = $maxOrder ? $maxOrder + 1 : 1;
        }

        return Speciality::create($data);
    }

    /**
     * Update an existing speciality
     */
    public function updateSpeciality($id, $data)
    {
        $speciality = Speciality::findOrFail($id);

        // Only generate new slug if title has changed
        if ($speciality->title !== $data['title']) {
            $data['slug'] = $this->generateUniqueSlug($data['title'], $id);
        }

        $speciality->update($data);

        return $speciality;
    }

    /**
     * Delete a speciality
     */
    public function deleteSpeciality($id)
    {
        $speciality = Speciality::findOrFail($id);
        return $speciality->delete();
    }

    /**
     * Toggle status of a speciality
     */
    public function changeStatus($id)
    {
        $speciality = Speciality::findOrFail($id);
        $speciality->status = $speciality->status === 'Active' ? 'Inactive' : 'Active';
        $speciality->save();

        return $speciality;
    }

    /**
     * Generate unique slug for speciality
     */
    private function generateUniqueSlug($title, $excludeId = null)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        // Check if slug exists, excluding current speciality if updating
        $query = Speciality::where('slug', $slug);
        if ($excludeId) {
            $query->where('speciality_id', '!=', $excludeId);
        }

        while ($query->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $query = Speciality::where('slug', $slug);
            if ($excludeId) {
                $query->where('speciality_id', '!=', $excludeId);
            }
            $counter++;
        }

        return $slug;
    }
}

