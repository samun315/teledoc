<?php

namespace App\Http\Controllers\Expertise;

use App\Http\Controllers\Controller;
use App\Http\Requests\Expertise\ExpertiseRequest;
use App\Services\Expertise\ExpertiseService;
use Illuminate\Http\Request;

class ExpertiseController extends Controller
{
    protected $expertiseService;

    public function __construct(ExpertiseService $expertiseService)
    {
        $this->expertiseService = $expertiseService;
    }

    /**
     * Display the expertise section settings page
     */
    public function index()
    {
        $expertise = $this->expertiseService->getOrCreateExpertiseSection();
        return view('expertise.index', compact('expertise'));
    }

    /**
     * Update the expertise section
     */
    public function update(ExpertiseRequest $request)
    {
        try {
            $this->expertiseService->updateExpertiseSection($request->validated());
            return response()->json([
                'success' => true,
                'message' => 'Expertise section updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating expertise section: ' . $e->getMessage()
            ], 500);
        }
    }
}

