<?php

namespace App\Http\Controllers\Marchant;

use App\Http\Controllers\Controller;
use App\Services\Marchant\BalanceRequestApproveService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BalanceRequestApproveController extends Controller
{
    public function __construct(protected BalanceRequestApproveService $balanceRequestApproveService) {}

    public function index(Request $request):View|JsonResponse
    {
        if ($request->ajax()) {
            return $this->balanceRequestApproveService->getBalanceRequest($request);
        }

        return view('marchant.approvedBalanceRequest.index');
    }

    public function updateStatus(Request $request, int $id): JsonResponse
    {
        // Get currency ID and status from the request
        $status = $request->input('status');

        try {
            // Update the status of the currency
            $whitelist = $this->balanceRequestApproveService->updateBalanceRequestStatus($request, $id);

            return sendSuccessResponse(200, 'Balance Request status updated successfully.');
        } catch (Exception $e) {
            // Handle any exceptions during status update
            return sendErrorResponse('Internal Server Error: ', $e->getMessage(), $e->getCode() ?? 500);
        }
    }
}
