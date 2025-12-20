<?php

namespace App\Http\Controllers\About;

use App\Http\Controllers\Controller;
use App\Http\Requests\About\AboutRequest;
use App\Services\About\AboutService;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    protected $aboutService;

    public function __construct(AboutService $aboutService)
    {
        $this->aboutService = $aboutService;
    }

    /**
     * Display the about section settings page
     */
    public function index()
    {
        $about = $this->aboutService->getOrCreateAboutSection();
        return view('about.index', compact('about'));
    }

    /**
     * Update the about section
     */
    public function update(AboutRequest $request)
    {
        try {
            $this->aboutService->updateAboutSection($request->validated());
            return response()->json([
                'success' => true,
                'message' => 'About section updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating about section: ' . $e->getMessage()
            ], 500);
        }
    }
}

