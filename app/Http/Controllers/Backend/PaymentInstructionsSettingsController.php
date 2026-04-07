<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\PaymentInstructionHero\PaymentInstructionHeroService;
use App\Services\PaymentMode\PaymentModeService;
use App\Services\PaymentTermItem\PaymentTermItemService;
use App\Services\PaymentQuickSummaryItem\PaymentQuickSummaryItemService;

class PaymentInstructionsSettingsController extends Controller
{
    public function __construct(
        private PaymentInstructionHeroService $paymentInstructionHeroService,
        private PaymentModeService $paymentModeService,
        private PaymentTermItemService $paymentTermItemService,
        private PaymentQuickSummaryItemService $paymentQuickSummaryItemService
    ) {}

    public function index()
    {
        $hero = $this->paymentInstructionHeroService->getOrCreateForAdmin();
        $paymentModes = $this->paymentModeService->allForAdmin();
        $paymentTermItems = $this->paymentTermItemService->allForAdmin();
        $paymentQuickSummaryItems = $this->paymentQuickSummaryItemService->allForAdmin();

        return view('backend.settings.payment-instructions', compact(
            'hero',
            'paymentModes',
            'paymentTermItems',
            'paymentQuickSummaryItems'
        ));
    }
}
