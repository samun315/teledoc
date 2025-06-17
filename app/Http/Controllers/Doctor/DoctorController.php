<?php

namespace App\Http\Controllers\Doctor;

use App\Constant\Patient\PatientConstant;
use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\DoctorRequest;
use App\Http\Requests\Patient\PatientRequest;
use App\Models\Doctor\DoctorDepartment;
use App\Services\Doctor\DoctorService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DoctorController extends Controller
{
    public function __construct(protected DoctorService $doctorService) {}

    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            return $this->doctorService->getDoctorList($request);
        }

        $data['departments'] = DoctorDepartment::query()->where('status', 'Active')->get(['department_id', 'department_name']);

        return view('doctor.doctor.index',$data);
    }

    public function create(): View
    {
        $data['departments'] = DoctorDepartment::query()->where('status', 'Active')->get(['department_id', 'department_name']);

        return view('doctor.doctor.create', $data);
    }

    public function store(DoctorRequest $request): RedirectResponse
    {
        try {

            $storeUserInfo = $this->doctorService->storeDoctor($request);

            return to_route('patient.index')->with(
                'success',
                'Patient Stored successfully.'
            );
        } catch (Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function edit(int $patientId): View
    {
        $data['genderList'] = PatientConstant::GENDERS;
        $data['bloodGroupList'] = PatientConstant::BLOOD_GROUPS;
        $data['maritalStatusList'] = PatientConstant::MARITAL_STATUSES;

        $data['editModeData'] = $this->doctorService->getDoctorById($patientId);

        return view('doctor.doctor.create', $data);
    }


    public function update(DoctorRequest $request, int $patientId): RedirectResponse
    {
        try {

            $storeUserInfo = $this->doctorService->updateDoctor($request, $patientId);

            return to_route('patient.index')->with(
                'success',
                'Patient Updated successfully.'
            );
        } catch (Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }


    public function view(int $patientId): View
    {

        $data['editModeData'] = $this->doctorService->getDoctorById($patientId);

        return view('doctor.doctor.view', $data);
    }
}
