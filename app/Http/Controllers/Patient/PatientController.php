<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Services\Patient\PatientService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PatientController extends Controller
{
    public function __construct(protected PatientService $patientService) {}

    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            return $this->patientService->getPatientList($request);
        }

        return view('patient.index');
    }

    public function create():View
    {
        return view('patient.create');

    }
}
