<?php

namespace App\Http\Controllers\Drug;

use App\Http\Controllers\Controller;
use App\Http\Requests\Drug\PrescriptionRequest;
use App\Models\Doctor\Doctor;
use App\Models\Drug\Drug;
use App\Models\Drug\DrugAdvice;
use App\Models\Drug\DrugDoses;
use App\Models\Drug\DrugDuration;
use App\Models\Drug\DrugStrength;
use App\Models\Drug\DrugType;
use App\Models\Drug\Prescription;
use App\Models\Drug\SubscriptionType;
use App\Models\Patient\Patient;
use App\Services\Drug\PrescriptionService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PrescriptionController extends Controller
{
    public function __construct(protected PrescriptionService $prescriptionService) {}

    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            return $this->prescriptionService->getPrescriptionList($request);
        }

        return view('drugs.prescription.index');
    }

    public function create(int $patientId): View
    {
        $data['drugTypes'] = DrugType::query()->whereNot('status', 'Inactive')->get(['drug_type_id', 'drug_type']);
        $data['drugs'] = Drug::query()->whereNot('status', 'Inactive')->get(['drug_id', 'trade_name']);
        $data['drugStrengths'] = DrugStrength::query()->whereNot('status', 'Inactive')->get(['drug_strength_id', 'drug_strength']);
        $data['drugDoses'] = DrugDoses::query()->whereNot('status', 'Inactive')->get(['drug_dose_id', 'drug_dose']);
        $data['drugDurations'] = DrugDuration::query()->whereNot('status', 'Inactive')->get(['drug_duration_id', 'drug_duration']);
        $data['drugAdvices'] = DrugAdvice::query()->whereNot('status', 'Inactive')->get(['drug_advice_id', 'drug_advice']);

        $data['patientInfo'] = Patient::query()->where('patient_id', $patientId)->first();
        $data['doctorInfos'] = Doctor::query()->whereNot('status', 'Inactive')->get(['doctor_id', 'title', 'name']);
        $data['oldPrescriptionInfos'] = Prescription::query()->where('patient_id', $patientId)->get(['prescription_id', 'prescription_number', 'created_at']);
        $data['subscriptionTypes'] = SubscriptionType::query()->where('status', 'Active')->get(['subscription_type_id', 'subscription_type']);

        return view('drugs.prescription.create', $data);
    }


    public function store(PrescriptionRequest $request): RedirectResponse
    {
        try {

            $this->prescriptionService->createPrescription($request->fields());

             return to_route('drug.prescription.index')->with('success', 'Prescription created successfully.');
           
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function getPatientList(): JsonResponse
    {
        $data = $this->prescriptionService->getPatientList();
        return sendSuccessResponse(200, '', 'patientInfo', $data);
    }

    public function getSubscriptionList(int $subscriptionTypeId): JsonResponse
    {
        $data = $this->prescriptionService->getSubscriptionList($subscriptionTypeId);
        return sendSuccessResponse(200, '', 'subscriptions', $data);
    }

    public function createSubscription(Request $request, int $subscriptionTypeId): JsonResponse
    {
        $data = $this->prescriptionService->createSubscription($request, $subscriptionTypeId);
        return sendSuccessResponse(200, '', 'subscription', $data);
    }

    public function getDoctorPrescriptionList(int $doctorId, int $patientId): JsonResponse
    {
        $data = $this->prescriptionService->getDoctorPrescriptionList($doctorId, $patientId);
        return sendSuccessResponse(200, '', 'prescription', $data);
    }

    public function getOldPrescriptionList(int $prescriptionId): JsonResponse
    {
        $data = $this->prescriptionService->getOldPrescriptionList($prescriptionId);
        return sendSuccessResponse(200, '', 'prescription', $data);
    }


    public function getDrugDoseByType(int $drugTypeId): JsonResponse
    {
        $data = $this->prescriptionService->getDrugDoseByType($drugTypeId);
        return sendSuccessResponse(200, '', 'doses', $data);
    }


    public function edit(int $subscriptionId): JsonResponse
    {
        $data = $this->prescriptionService->getSubscriptionById($subscriptionId);
        return sendSuccessResponse(200, '', 'subscriptionInfo', $data);
    }

    public function update(PrescriptionRequest $request, int $subscriptionId): JsonResponse
    {
        try {

            $this->prescriptionService->updateSubscription($request->fields(), $subscriptionId);
            return sendSuccessResponse(201, 'Subscription updated successfully.');
        } catch (Exception $e) {
            return sendErrorResponse('Internal Server Error: ', $e->getMessage());
        }
    }
}
