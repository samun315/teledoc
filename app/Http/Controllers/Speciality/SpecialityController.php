<?php

namespace App\Http\Controllers\Speciality;

use App\Http\Controllers\Controller;
use App\Http\Requests\Speciality\SpecialityRequest;
use App\Services\Speciality\SpecialityService;
use Illuminate\Http\Request;

class SpecialityController extends Controller
{
    protected $specialityService;

    public function __construct(SpecialityService $specialityService)
    {
        $this->specialityService = $specialityService;
    }

    public function index()
    {
        $specialities = $this->specialityService->getAllSpecialities();
        return view('pages.speciality.index', compact('specialities'));
    }

    public function create()
    {
        return view('pages.speciality.create');
    }

    public function store(SpecialityRequest $request)
    {
        try {
            $this->specialityService->createSpeciality($request->validated());
            return redirect()->route('speciality.index')->with('success', 'Speciality created successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to create speciality: ' . $e->getMessage());
        }
    }

    public function edit($speciality_id)
    {
        try {
            $speciality = $this->specialityService->getSpecialityById($speciality_id);
            return view('pages.speciality.edit', compact('speciality'));
        } catch (\Exception $e) {
            return redirect()->route('speciality.index')->with('error', 'Speciality not found');
        }
    }

    public function update(SpecialityRequest $request, $speciality_id)
    {
        try {
            $this->specialityService->updateSpeciality($speciality_id, $request->validated());
            return redirect()->route('speciality.index')->with('success', 'Speciality updated successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to update speciality: ' . $e->getMessage());
        }
    }

    public function destroy($speciality_id)
    {
        try {
            $this->specialityService->deleteSpeciality($speciality_id);
            return response()->json(['success' => true, 'message' => 'Speciality deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete speciality: ' . $e->getMessage()], 500);
        }
    }

    public function changeStatus($speciality_id)
    {
        try {
            $speciality = $this->specialityService->changeStatus($speciality_id);
            return response()->json(['success' => true, 'status' => $speciality->status, 'message' => 'Status updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update status: ' . $e->getMessage()], 500);
        }
    }

    public function getAll()
    {
        try {
            $specialities = $this->specialityService->getAllSpecialities();
            return response()->json(['data' => $specialities]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch specialities'], 500);
        }
    }
}

