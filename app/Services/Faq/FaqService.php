<?php

namespace App\Services\Faq;

use App\Models\Faq\Faq;

class FaqService
{
    /**
     * Get all FAQs
     */
    public function getAllFaqs()
    {
        return Faq::orderBy('order', 'asc')->get();
    }

    /**
     * Get active FAQs for frontend
     */
    public function getActiveFaqs()
    {
        return Faq::where('status', 'Active')
            ->orderBy('order', 'asc')
            ->get();
    }

    /**
     * Get a specific FAQ by ID
     */
    public function getFaqById($id)
    {
        return Faq::findOrFail($id);
    }

    /**
     * Create a new FAQ
     */
    public function createFaq($data)
    {
        // Set order to last if not provided
        if (!isset($data['order']) || $data['order'] === null) {
            $maxOrder = Faq::max('order');
            $data['order'] = $maxOrder ? $maxOrder + 1 : 1;
        }

        return Faq::create($data);
    }

    /**
     * Update an existing FAQ
     */
    public function updateFaq($id, $data)
    {
        $faq = Faq::findOrFail($id);
        $faq->update($data);

        return $faq;
    }

    /**
     * Delete a FAQ
     */
    public function deleteFaq($id)
    {
        $faq = Faq::findOrFail($id);
        return $faq->delete();
    }

    /**
     * Toggle status of a FAQ
     */
    public function changeStatus($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->status = $faq->status === 'Active' ? 'Inactive' : 'Active';
        $faq->save();

        return $faq;
    }
}

