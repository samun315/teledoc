<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentMode\StorePaymentModeRequest;
use App\Http\Requests\PaymentMode\UpdatePaymentModeRequest;
use App\Models\PaymentMode\PaymentMode;
use App\Services\PaymentMode\PaymentModeService;

class PaymentModeController extends Controller
{
    public function __construct(
        private PaymentModeService $paymentModeService
    ) {}

    public function show(PaymentMode $paymentMode)
    {
        return response()->json([
            'payment_mode' => [
                'id' => $paymentMode->id,
                'title' => $paymentMode->title,
                'image' => $paymentMode->image,
                'image_url' => $paymentMode->image ? asset('storage/'.$paymentMode->image) : null,
                'account_details' => $paymentMode->account_details,
                'instruction' => $paymentMode->instruction,
                'sort_order' => $paymentMode->sort_order,
                'is_active' => $paymentMode->is_active,
            ],
        ]);
    }

    public function store(StorePaymentModeRequest $request)
    {
        try {
            $data = $request->validated();
            $data['is_active'] = $request->boolean('is_active', true);
            $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
            $mode = $this->paymentModeService->create($data);

            return response()->json([
                'success' => true,
                'message' => 'Payment mode created.',
                'payment_mode' => $mode,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(UpdatePaymentModeRequest $request, PaymentMode $paymentMode)
    {
        try {
            $data = $request->validated();
            $data['is_active'] = $request->boolean('is_active', true);
            $data['sort_order'] = isset($data['sort_order']) ? (int) $data['sort_order'] : $paymentMode->sort_order;
            if ($request->boolean('remove_image')) {
                $data['remove_image'] = true;
            }
            $mode = $this->paymentModeService->update($paymentMode, $data);

            return response()->json([
                'success' => true,
                'message' => 'Payment mode updated.',
                'payment_mode' => $mode,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(PaymentMode $paymentMode)
    {
        try {
            $this->paymentModeService->delete($paymentMode);

            return response()->json([
                'success' => true,
                'message' => 'Payment mode deleted.',
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
