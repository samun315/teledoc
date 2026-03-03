<?php

namespace App\Http\Controllers\PrivacyPolicy;

use App\Http\Controllers\Controller;
use App\Http\Requests\PrivacyPolicy\UpdatePrivacyPolicyRequest;
use App\Services\PrivacyPolicy\PrivacyPolicyService;
use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
{
    protected $privacyPolicyService;

    public function __construct(PrivacyPolicyService $privacyPolicyService)
    {
        $this->privacyPolicyService = $privacyPolicyService;
    }

    /**
     * Display the privacy policy settings page (always in edit mode)
     */
    public function index()
    {
        $privacyPolicy = $this->privacyPolicyService->getOrCreatePrivacyPolicy();
        return view('privacy-policy.index', compact('privacyPolicy'));
    }

    /**
     * Update the privacy policy
     */
    public function update(UpdatePrivacyPolicyRequest $request)
    {
        try {
            $this->privacyPolicyService->updatePrivacyPolicy($request->validated());
            return response()->json([
                'success' => true,
                'message' => 'Privacy policy updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating privacy policy: ' . $e->getMessage()
            ], 500);
        }
    }
}
