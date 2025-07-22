<?php

namespace App\Http\Controllers\Drug;

use App\Http\Controllers\Controller;
use App\Http\Requests\Drug\PrescriptionRequest;
use App\Services\Drug\PrescriptionService;
use Exception;
use Illuminate\Http\JsonResponse;
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

    public function create(): View
    {

        return view('drugs.prescription.create');
    }


    public function store(PrescriptionRequest $request): JsonResponse
    {
        try {

            $this->prescriptionService->createSubscription($request->fields());
            return sendSuccessResponse(201, 'Subscription created successfully.');
        } catch (Exception $e) {
            return sendErrorResponse('Internal Server Error: ', $e->getMessage());
        }
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
