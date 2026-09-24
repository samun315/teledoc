<?php

namespace App\Services\PaymentMode;

use App\Models\PaymentMode\PaymentMode;
use App\Services\Media\ImageOptimizer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class PaymentModeService
{
    private const CACHE_KEY = 'payment_modes.active.v1';

    public function allForAdmin(): Collection
    {
        return PaymentMode::query()->orderBy('sort_order')->orderBy('id')->get();
    }

    public function activeOrdered(): Collection
    {
        return Cache::remember(self::CACHE_KEY, 86400, function () {
            return PaymentMode::query()
                ->active()
                ->ordered()
                ->get();
        });
    }

    public function create(array $data): PaymentMode
    {
        if (! empty($data['image'] ?? null)) {
            $data['image'] = $this->storeImage($data['image']);
        } else {
            unset($data['image']);
        }

        $mode = PaymentMode::create($data);
        Cache::forget(self::CACHE_KEY);

        return $mode;
    }

    public function update(PaymentMode $mode, array $data): PaymentMode
    {
        if (! empty($data['remove_image'] ?? false)) {
            $this->deleteImageIfExists($mode->image);
            $data['image'] = null;
        }
        unset($data['remove_image']);

        if (! empty($data['image'] ?? null)) {
            $this->deleteImageIfExists($mode->image);
            $data['image'] = $this->storeImage($data['image']);
        } else {
            unset($data['image']);
        }

        $mode->update($data);
        Cache::forget(self::CACHE_KEY);

        return $mode->fresh();
    }

    public function delete(PaymentMode $mode): void
    {
        $this->deleteImageIfExists($mode->image);
        $mode->delete();
        Cache::forget(self::CACHE_KEY);
    }

    private function storeImage($file): string
    {
        return app(ImageOptimizer::class)->storeOnDisk($file, 'payment-modes');
    }

    private function deleteImageIfExists(?string $path): void
    {
        app(ImageOptimizer::class)->delete($path);
    }
}
