<?php

namespace App\Services\PrivacyPolicy;

use App\Models\PrivacyPolicy\PrivacyPolicy;
use Illuminate\Support\Facades\Auth;

class PrivacyPolicyService
{
    /**
     * Get or create single privacy policy
     */
    public function getOrCreatePrivacyPolicy()
    {
        $privacyPolicy = PrivacyPolicy::first();
        if (!$privacyPolicy) {
            $privacyPolicy = PrivacyPolicy::create([
                'privacy_policy' => '',
                'created_by' => Auth::id(),
            ]);
        }
        return $privacyPolicy;
    }

    /**
     * Get active privacy policy for frontend
     */
    public function getActivePrivacyPolicy()
    {
        return PrivacyPolicy::first();
    }

    /**
     * Update the privacy policy (single record)
     */
    public function updatePrivacyPolicy($data)
    {
        $privacyPolicy = PrivacyPolicy::first();
        
        if (!$privacyPolicy) {
            $privacyPolicy = PrivacyPolicy::create([
                'privacy_policy' => $data['privacy_policy'] ?? '',
                'created_by' => Auth::id(),
            ]);
        }

        $data['updated_by'] = Auth::id();
        $privacyPolicy->update($data);

        return $privacyPolicy;
    }
}
