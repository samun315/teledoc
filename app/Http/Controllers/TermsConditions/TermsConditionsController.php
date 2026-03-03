<?php

namespace App\Http\Controllers\TermsConditions;

use App\Http\Controllers\Controller;
use App\Http\Requests\TermsConditions\UpdateTermsConditionsRequest;
use App\Services\TermsConditions\TermsConditionsService;
use Illuminate\Http\Request;

class TermsConditionsController extends Controller
{
    protected $termsConditionsService;

    public function __construct(TermsConditionsService $termsConditionsService)
    {
        $this->termsConditionsService = $termsConditionsService;
    }

    /**
     * Display the terms and conditions settings page (always in edit mode)
     */
    public function index()
    {
        $termsConditions = $this->termsConditionsService->getOrCreateTermsConditions();
        return view('terms-conditions.index', compact('termsConditions'));
    }

    /**
     * Update the terms and conditions
     */
    public function update(UpdateTermsConditionsRequest $request)
    {
        try {
            $this->termsConditionsService->updateTermsConditions($request->validated());
            return response()->json([
                'success' => true,
                'message' => 'Terms and conditions updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating terms and conditions: ' . $e->getMessage()
            ], 500);
        }
    }
}
