<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Services\Payment\PendingPaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PendingPaymentController extends Controller
{
    public function __construct(protected PendingPaymentService $pendingPaymentService) {}

    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            return $this->pendingPaymentService->getPendingPayments($request);
        }

        return view('payment.pendingPayment.index');
    }
}
