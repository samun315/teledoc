<?php

namespace App\Http\Controllers\Marchant;

use App\Http\Controllers\Controller;
use App\Services\Marchant\TransferApproveService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TransferApproveController extends Controller
{
    public function __construct(protected TransferApproveService $transferApproveService) {}

    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            return $this->transferApproveService->getTransferBalanceInfo($request);
        }
 
        return view('marchant.transferApprove.index');
    }

    public function updateStatus(Request $request, int $id): JsonResponse
    {
        try {
            // Update the status of the currency
            $whitelist = $this->transferApproveService->updateTransferBalanceStatus($request, $id);

            return sendSuccessResponse(200, 'Transfer balance status updated successfully.');
        } catch (Exception $e) {
            // Handle any exceptions during status update
            return sendErrorResponse('Internal Server Error: ', $e->getMessage(), $e->getCode() ?? 500);
        }
    }
}
