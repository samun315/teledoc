<?php

namespace App\Services\PaymentQuickSummaryItem;

use App\Models\PaymentQuickSummaryItem\PaymentQuickSummaryItem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class PaymentQuickSummaryItemService
{
    private const CACHE_KEY = 'payment_quick_summary_items.active.v1';

    public function allForAdmin(): Collection
    {
        return PaymentQuickSummaryItem::query()->orderBy('sort_order')->orderBy('id')->get();
    }

    public function activeOrdered(): Collection
    {
        return Cache::remember(self::CACHE_KEY, 86400, function () {
            return PaymentQuickSummaryItem::query()->active()->ordered()->get();
        });
    }

    public function create(array $data): PaymentQuickSummaryItem
    {
        $item = PaymentQuickSummaryItem::create($data);
        Cache::forget(self::CACHE_KEY);

        return $item;
    }

    public function update(PaymentQuickSummaryItem $item, array $data): PaymentQuickSummaryItem
    {
        $item->update($data);
        Cache::forget(self::CACHE_KEY);

        return $item->fresh();
    }

    public function delete(PaymentQuickSummaryItem $item): void
    {
        $item->delete();
        Cache::forget(self::CACHE_KEY);
    }
}
