<?php

namespace App\Http\Controllers\Drug;

use App\Http\Controllers\Controller;
use App\Http\Requests\Drug\SubscriptionRequest;
use App\Models\Drug\Subscription;
use App\Models\Drug\SubscriptionType;
use App\Services\Drug\SubscriptionService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubscriptionController extends Controller
{
    public function __construct(protected SubscriptionService $subscriptionService) {}

    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            return $this->subscriptionService->getSubscriptionList($request);
        }
        $data['subscriptionTypes'] =  SubscriptionType::query()->orderBy('orders')->get();

        return view('drugs.subscription.index', $data);
    }

    public function store(SubscriptionRequest $request): JsonResponse
    {
        try {

            $this->subscriptionService->createSubscription($request->fields());
            return sendSuccessResponse(201, 'Subscription created successfully.');
        } catch (Exception $e) {
            return sendErrorResponse('Internal Server Error: ', $e->getMessage());
        }
    }

    public function edit(int $subscriptionId): JsonResponse
    {
        $data = $this->subscriptionService->getSubscriptionById($subscriptionId);
        return sendSuccessResponse(200, '', 'subscriptionInfo', $data);
    }

    public function update(SubscriptionRequest $request, int $subscriptionId): JsonResponse
    {
        try {

            $this->subscriptionService->updateSubscription($request->fields(), $subscriptionId);
            return sendSuccessResponse(201, 'Subscription updated successfully.');
        } catch (Exception $e) {
            return sendErrorResponse('Internal Server Error: ', $e->getMessage());
        }
    }
}
