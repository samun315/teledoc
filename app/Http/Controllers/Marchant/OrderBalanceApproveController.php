<?php

namespace App\Http\Controllers\Marchant;

use App\Http\Controllers\Controller;
use App\Services\Marchant\OrderBalanceApproveService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderBalanceApproveController extends Controller
{
    public function __construct(protected OrderBalanceApproveService $orderBalanceApproveService) {}

    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            return $this->orderBalanceApproveService->getOrderBalanceInfo($request);
        }
        return view('marchant.orderApprove.index');
    }


    public function updateStatus(Request $request, int $id): JsonResponse
    {
        try {
            // Update the status of the currency
            $whitelist = $this->orderBalanceApproveService->updateOrderBalanceRequestStatus($request, $id);

            return sendSuccessResponse(200, 'Order Balance status updated successfully.');
        } catch (Exception $e) {
            // Handle any exceptions during status update
            return sendErrorResponse('Internal Server Error: ', $e->getMessage(), $e->getCode() ?? 500);
        }
    }
}
