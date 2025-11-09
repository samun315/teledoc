<?php

namespace App\Http\Controllers\Testimonial;

use App\Http\Controllers\Controller;
use App\Http\Requests\Testimonial\TestimonialRequest;
use App\Services\Testimonial\TestimonialService;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    protected $testimonialService;

    public function __construct(TestimonialService $testimonialService)
    {
        $this->testimonialService = $testimonialService;
    }

    public function index()
    {
        $testimonials = $this->testimonialService->getAllTestimonials();
        return view('pages.testimonial.index', compact('testimonials'));
    }

    public function create()
    {
        return view('pages.testimonial.create');
    }

    public function store(TestimonialRequest $request)
    {
        try {
            $this->testimonialService->createTestimonial($request->validated());
            return redirect()->route('testimonial.index')->with('success', 'Testimonial created successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to create testimonial: ' . $e->getMessage());
        }
    }

    public function edit($testimonial_id)
    {
        try {
            $testimonial = $this->testimonialService->getTestimonialById($testimonial_id);
            return view('pages.testimonial.edit', compact('testimonial'));
        } catch (\Exception $e) {
            return redirect()->route('testimonial.index')->with('error', 'Testimonial not found');
        }
    }

    public function update(TestimonialRequest $request, $testimonial_id)
    {
        try {
            $this->testimonialService->updateTestimonial($testimonial_id, $request->validated());
            return redirect()->route('testimonial.index')->with('success', 'Testimonial updated successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to update testimonial: ' . $e->getMessage());
        }
    }

    public function destroy($testimonial_id)
    {
        try {
            $this->testimonialService->deleteTestimonial($testimonial_id);
            return response()->json(['success' => true, 'message' => 'Testimonial deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete testimonial: ' . $e->getMessage()], 500);
        }
    }

    public function changeStatus($testimonial_id)
    {
        try {
            $testimonial = $this->testimonialService->changeStatus($testimonial_id);
            return response()->json(['success' => true, 'status' => $testimonial->status, 'message' => 'Status updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update status: ' . $e->getMessage()], 500);
        }
    }

    public function getAll()
    {
        try {
            $testimonials = $this->testimonialService->getAllTestimonials();
            return response()->json(['data' => $testimonials]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch testimonials'], 500);
        }
    }
}

