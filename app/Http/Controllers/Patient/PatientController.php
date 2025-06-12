<?php

namespace App\Http\Controllers\Patient;

use App\Constant\Patient\PatientConstant;
use App\Http\Controllers\Controller;
use App\Http\Requests\Patient\PatientRequest;
use App\Services\Patient\PatientService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
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

    public function create(): View
    {
        $data['genderList'] = PatientConstant::GENDERS;
        $data['bloodGroupList'] = PatientConstant::BLOOD_GROUPS;
        $data['maritalStatusList'] = PatientConstant::MARITAL_STATUSES;

        return view('patient.create', $data);
    }

        public function store(PatientRequest $request): RedirectResponse
    {
        try {

            $storeUserInfo = $this->patientService->storePatient($request);

            return to_route('patient.index')->with(
                'success',
                'Patient Stored successfully.'
            );
        } catch (Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}
