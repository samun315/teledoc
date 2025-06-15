<?php

namespace App\Http\Controllers\Drug;

use App\Http\Controllers\Controller;
use App\Http\Requests\Drug\SubscriptionTypeRequest;
use App\Models\Drug\SubscriptionType;
use App\Services\Drug\SubscriptionTypeService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubscriptionTypeController extends Controller
{
    public function __construct(protected SubscriptionTypeService $subscriptionTypeService) {}

    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            return $this->subscriptionTypeService->getSubscriptionTypeList($request);
        }

        return view('drugs.subscriptionType.index');
    }

    public function store(SubscriptionTypeRequest $request): JsonResponse
    {
        try {

            $this->subscriptionTypeService->createSubscriptionType($request->fields());
            return sendSuccessResponse(201, 'Subscription Type created successfully.');
        } catch (Exception $e) {
            return sendErrorResponse('Internal Server Error: ', $e->getMessage());
        }
    }

    public function edit(int $subscriptionTypeId): JsonResponse
    {
        $data = $this->subscriptionTypeService->getSubscriptionTypeById($subscriptionTypeId);
        return sendSuccessResponse(200, '', 'subscriptionTypeInfo', $data);
    }

    public function update(SubscriptionTypeRequest $request, int $subscriptionTypeId): JsonResponse
    {
        try {

            $this->subscriptionTypeService->updateSubscriptionType($request->fields(), $subscriptionTypeId);
            return sendSuccessResponse(201, 'Subscription Type updated successfully.');
        } catch (Exception $e) {
            return sendErrorResponse('Internal Server Error: ', $e->getMessage());
        }
    }

    public function reorder(Request $request): View|JsonResponse
    {
        $data['subscriptionTypes'] =  SubscriptionType::query()->orderBy('orders')->get();

        return view('drugs.subscriptionType.reorder', $data);
    }

    
    public function reorderUpdate(Request $request): JsonResponse
    {
        try {
            $subscriptionItemOrder = json_decode($request->order);
         
            $itemOrderInfo = $this->subscriptionTypeService->orderSubscription($subscriptionItemOrder);

            return sendSuccessResponse(200, 'Successfully updated subscription order', 'itemOrderInfo', $itemOrderInfo);
        } catch (Exception $exception) {
            // dd($exception);
            return sendErrorResponse('Internal Server Error: ', $exception->getMessage(), $exception->getCode() ?? 500);
        }
    }
}
