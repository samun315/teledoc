<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentTermItem\StorePaymentTermItemRequest;
use App\Http\Requests\PaymentTermItem\UpdatePaymentTermItemRequest;
use App\Models\PaymentTermItem\PaymentTermItem;
use App\Services\PaymentTermItem\PaymentTermItemService;

class PaymentTermItemController extends Controller
{
    public function __construct(
        private PaymentTermItemService $paymentTermItemService
    ) {}

    public function show(PaymentTermItem $payment_term_item)
    {
        $item = $payment_term_item;

        return response()->json([
            'payment_term_item' => [
                'id' => $item->id,
                'title' => $item->title,
                'description' => $item->description,
                'icon' => $item->icon,
                'icon_color' => $item->icon_color,
                'sort_order' => $item->sort_order,
                'is_active' => $item->is_active,
            ],
        ]);
    }

    public function store(StorePaymentTermItemRequest $request)
    {
        try {
            $data = $request->validated();
            $data['is_active'] = $request->boolean('is_active', true);
            $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
            $item = $this->paymentTermItemService->create($data);

            return response()->json([
                'success' => true,
                'message' => 'Term item created.',
                'payment_term_item' => $item,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(UpdatePaymentTermItemRequest $request, PaymentTermItem $payment_term_item)
    {
        try {
            $data = $request->validated();
            $data['is_active'] = $request->boolean('is_active', true);
            $data['sort_order'] = isset($data['sort_order']) ? (int) $data['sort_order'] : $payment_term_item->sort_order;
            $item = $this->paymentTermItemService->update($payment_term_item, $data);

            return response()->json([
                'success' => true,
                'message' => 'Term item updated.',
                'payment_term_item' => $item,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(PaymentTermItem $payment_term_item)
    {
        try {
            $this->paymentTermItemService->delete($payment_term_item);

            return response()->json([
                'success' => true,
                'message' => 'Term item deleted.',
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
