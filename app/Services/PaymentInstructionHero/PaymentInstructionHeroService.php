<?php

namespace App\Services\PaymentInstructionHero;

use App\Models\PaymentInstructionHero\PaymentInstructionHero;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PaymentInstructionHeroService
{
    private const CACHE_KEY = 'payment_instruction_hero.frontend.v1';

    private const DEFAULT_TITLE = 'Pay for your consultation with confidence';

    private const DEFAULT_DESCRIPTION = '<p>Follow the steps for your preferred method—bKash, Nagad, or card. Account numbers and '
        .'instructions are listed below. Please read the payment terms so your booking stays valid '
        .'and we can confirm you without delay.</p>';

    private const DEFAULT_BANNER = 'frontend/assets/img/home-one/6.jpg';

    public function getOrCreateForAdmin(): PaymentInstructionHero
    {
        $row = PaymentInstructionHero::query()->first();
        if ($row) {
            return $row;
        }

        return PaymentInstructionHero::create([
            'title' => self::DEFAULT_TITLE,
            'description' => self::DEFAULT_DESCRIPTION,
            'status' => 'Active',
        ]);
    }

    /**
     * Cached read for public payment instructions page (single query + array shape).
     *
     * @return array{title: string, description: string, banner_src: string}
     */
    public function getHeroForFrontend(): array
    {
        return Cache::remember(self::CACHE_KEY, 86400, function () {
            $row = PaymentInstructionHero::query()
                ->select(['id', 'title', 'description', 'banner_image', 'status'])
                ->first();

            if (! $row || $row->status !== 'Active') {
                return $this->defaultPresentation();
            }

            $bannerSrc = $row->banner_image
                ? asset('storage/'.$row->banner_image)
                : asset(self::DEFAULT_BANNER);

            return [
                'title' => $row->title,
                'description' => $row->description,
                'banner_src' => $bannerSrc,
            ];
        });
    }

    public function updateHero(array $data): PaymentInstructionHero
    {
        $hero = PaymentInstructionHero::query()->firstOrFail();

        if (! empty($data['banner_image'] ?? null)) {
            if ($hero->banner_image) {
                Storage::disk('public')->delete($hero->banner_image);
            }
            $data['banner_image'] = $this->uploadBanner($data['banner_image']);
        } else {
            unset($data['banner_image']);
        }

        $hero->update($data);
        Cache::forget(self::CACHE_KEY);

        return $hero->fresh();
    }

    private function uploadBanner($file): string
    {
        $filename = time().'_'.Str::random(10).'.'.$file->getClientOriginalExtension();

        return $file->storeAs('payment-instruction-hero', $filename, 'public');
    }

    /**
     * @return array{title: string, description: string, banner_src: string}
     */
    private function defaultPresentation(): array
    {
        return [
            'title' => self::DEFAULT_TITLE,
            'description' => self::DEFAULT_DESCRIPTION,
            'banner_src' => asset(self::DEFAULT_BANNER),
        ];
    }
}
