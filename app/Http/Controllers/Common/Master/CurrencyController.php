<?php

namespace App\Http\Controllers\Common\Master;

use App\Http\Controllers\Controller;
use App\Services\Common\Currency\CurrencyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CurrencyController extends Controller
{
    public function __construct(protected CurrencyService $currencyService)
    {
    }

    public function index(Request $request):View|JsonResponse
    {
        if ($request->ajax()) {
            return $this->currencyService->getCurrencyList($request);
        }
        return view('common.master.currency.index');
    }

    public function updateStatus(Request $request): JsonResponse
    {
        // Get currency ID and status from the request
        $id = $request->input('id');
        $active = $request->input('active');

        try {
            // Update the status of the currency
            $this->currencyService->updateCurrencyStatus(['active' => $active], $id);

            return sendSuccessResponse(200, 'Currency status updated successfully.');
        } catch (\Exception $e) {
            // Handle any exceptions during status update
            return sendErrorResponse('Internal Server Error: ', $e->getMessage(), $e->getCode() ?? 500);
        }
    }
}
