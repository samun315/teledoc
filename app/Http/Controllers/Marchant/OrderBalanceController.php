<?php

namespace App\Http\Controllers\Marchant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Marchant\OrderBalanceRequest;
use App\Models\Payment\PaymentGateway;
use App\Services\Marchant\OrderBalanceService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderBalanceController extends Controller
{
    public function __construct(protected OrderBalanceService $orderBalanceService) {}

    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            return $this->orderBalanceService->getOrderBalanceInfo($request);
        }
        return view('marchant.order.index');
    }

    public function create(): View
    {
        $data['paymentGateways'] = PaymentGateway::query()->where('active', 'YES')->get();

        return view('marchant.order.create', $data);
    }

    public function gatewayInfo(int $gatewayId): JsonResponse
    {
        try {
            $data = $this->orderBalanceService->gatewayInfo($gatewayId);

            return sendSuccessResponse(200, '', 'gatewayInfo', $data);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getOrderDetails(int $orderId): JsonResponse
    {
        try {
            $data = $this->orderBalanceService->getOrderDetails($orderId);
// dd($data);
            return sendSuccessResponse(200, '', 'data', $data);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function store(OrderBalanceRequest $request): RedirectResponse
    {
        try {

            $storeUserInfo = $this->orderBalanceService->storeOrderBalance($request);

            return to_route('marchant.order.balance.index')->with(
                'success',
                'Order Balance Stored successfully.'
            );
        } catch (Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}
