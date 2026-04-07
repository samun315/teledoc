<?php

namespace App\Services\PaymentTermItem;

use App\Models\PaymentTermItem\PaymentTermItem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class PaymentTermItemService
{
    private const CACHE_KEY = 'payment_term_items.active.v1';

    public function allForAdmin(): Collection
    {
        return PaymentTermItem::query()->orderBy('sort_order')->orderBy('id')->get();
    }

    public function activeOrdered(): Collection
    {
        return Cache::remember(self::CACHE_KEY, 86400, function () {
            return PaymentTermItem::query()->active()->ordered()->get();
        });
    }

    public function create(array $data): PaymentTermItem
    {
        $item = PaymentTermItem::create($data);
        Cache::forget(self::CACHE_KEY);

        return $item;
    }

    public function update(PaymentTermItem $item, array $data): PaymentTermItem
    {
        $item->update($data);
        Cache::forget(self::CACHE_KEY);

        return $item->fresh();
    }

    public function delete(PaymentTermItem $item): void
    {
        $item->delete();
        Cache::forget(self::CACHE_KEY);
    }
}
