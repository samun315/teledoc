<?php

namespace App\Services\TermsConditions;

use App\Models\TermsConditions\TermsConditions;
use Illuminate\Support\Facades\Auth;

class TermsConditionsService
{
    /**
     * Get or create single terms and conditions
     */
    public function getOrCreateTermsConditions()
    {
        $termsConditions = TermsConditions::first();
        if (!$termsConditions) {
            $termsConditions = TermsConditions::create([
                'terms_conditions' => '',
                'created_by' => Auth::id(),
            ]);
        }
        return $termsConditions;
    }

    /**
     * Get active terms and conditions for frontend
     */
    public function getActiveTermsConditions()
    {
        return TermsConditions::first();
    }

    /**
     * Update the terms and conditions (single record)
     */
    public function updateTermsConditions($data)
    {
        $termsConditions = TermsConditions::first();
        
        if (!$termsConditions) {
            $termsConditions = TermsConditions::create([
                'terms_conditions' => $data['terms_conditions'] ?? '',
                'created_by' => Auth::id(),
            ]);
        }

        $data['updated_by'] = Auth::id();
        $termsConditions->update($data);

        return $termsConditions;
    }
}
