<?php

namespace App\Http\Controllers\PaymentInstructionHero;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentInstructionHero\UpdatePaymentInstructionHeroRequest;
use App\Services\PaymentInstructionHero\PaymentInstructionHeroService;

class PaymentInstructionHeroController extends Controller
{
    public function __construct(
        private PaymentInstructionHeroService $paymentInstructionHeroService
    ) {}

    public function index()
    {
        return redirect()->route('admin.settings.payment-instructions.index', [
            'tab' => 'payment-instructions',
        ]);
    }

    public function update(UpdatePaymentInstructionHeroRequest $request)
    {
        try {
            $this->paymentInstructionHeroService->updateHero($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Payment instruction hero updated successfully!',
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating payment instruction hero: '.$e->getMessage(),
            ], 500);
        }
    }
}
