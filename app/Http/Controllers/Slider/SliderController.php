<?php

namespace App\Http\Controllers\Slider;

use App\Http\Controllers\Controller;
use App\Http\Requests\Slider\SliderRequest;
use App\Services\Slider\SliderService;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    protected $sliderService;

    public function __construct(SliderService $sliderService)
    {
        $this->sliderService = $sliderService;
    }

    public function index()
    {
        $sliders = $this->sliderService->getAllSliders();
        return view('slider.index', compact('sliders'));
    }

    public function create()
    {
        return view('slider.create');
    }

    public function store(SliderRequest $request)
    {
        try {
            $this->sliderService->createSlider($request->validated());
            return redirect()->route('slider.slider.index')->with('success', 'Slider created successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to create slider: ' . $e->getMessage());
        }
    }

    public function edit($slider_id)
    {
        try {
            $slider = $this->sliderService->getSliderById($slider_id);
            return view('slider.edit', compact('slider'));
        } catch (\Exception $e) {
            return redirect()->route('slider.slider.index')->with('error', 'Slider not found');
        }
    }

    public function update(SliderRequest $request, $slider_id)
    {
        try {
            $this->sliderService->updateSlider($slider_id, $request->validated());
            return redirect()->route('slider.slider.index')->with('success', 'Slider updated successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to update slider: ' . $e->getMessage());
        }
    }

    public function destroy($slider_id)
    {
        try {
            $this->sliderService->deleteSlider($slider_id);
            return redirect()->route('slider.slider.index')->with('success', 'Slider deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('slider.slider.index')->with('error', 'Failed to delete slider: ' . $e->getMessage());
        }
    }
}

