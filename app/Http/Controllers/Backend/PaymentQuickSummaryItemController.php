<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentQuickSummaryItem\StorePaymentQuickSummaryItemRequest;
use App\Http\Requests\PaymentQuickSummaryItem\UpdatePaymentQuickSummaryItemRequest;
use App\Models\PaymentQuickSummaryItem\PaymentQuickSummaryItem;
use App\Services\PaymentQuickSummaryItem\PaymentQuickSummaryItemService;

class PaymentQuickSummaryItemController extends Controller
{
    public function __construct(
        private PaymentQuickSummaryItemService $paymentQuickSummaryItemService
    ) {}

    public function show(PaymentQuickSummaryItem $payment_quick_summary_item)
    {
        $item = $payment_quick_summary_item;

        return response()->json([
            'payment_quick_summary_item' => [
                'id' => $item->id,
                'line_text' => $item->line_text,
                'badge_variant' => $item->badge_variant,
                'sort_order' => $item->sort_order,
                'is_active' => $item->is_active,
            ],
        ]);
    }

    public function store(StorePaymentQuickSummaryItemRequest $request)
    {
        try {
            $data = $request->validated();
            $data['is_active'] = $request->boolean('is_active', true);
            $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
            $data['badge_variant'] = (int) $data['badge_variant'];
            $item = $this->paymentQuickSummaryItemService->create($data);

            return response()->json([
                'success' => true,
                'message' => 'Quick summary line created.',
                'payment_quick_summary_item' => $item,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(UpdatePaymentQuickSummaryItemRequest $request, PaymentQuickSummaryItem $payment_quick_summary_item)
    {
        try {
            $data = $request->validated();
            $data['is_active'] = $request->boolean('is_active', true);
            $data['sort_order'] = isset($data['sort_order']) ? (int) $data['sort_order'] : $payment_quick_summary_item->sort_order;
            $data['badge_variant'] = (int) $data['badge_variant'];
            $item = $this->paymentQuickSummaryItemService->update($payment_quick_summary_item, $data);

            return response()->json([
                'success' => true,
                'message' => 'Quick summary line updated.',
                'payment_quick_summary_item' => $item,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(PaymentQuickSummaryItem $payment_quick_summary_item)
    {
        try {
            $this->paymentQuickSummaryItemService->delete($payment_quick_summary_item);

            return response()->json([
                'success' => true,
                'message' => 'Quick summary line deleted.',
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
