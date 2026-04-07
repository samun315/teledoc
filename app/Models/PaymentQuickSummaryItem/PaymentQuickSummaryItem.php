<?php

namespace App\Models\PaymentQuickSummaryItem;

use Illuminate\Database\Eloquent\Model;

class PaymentQuickSummaryItem extends Model
{
    protected $table = 'payment_quick_summary_items';

    protected $fillable = [
        'line_text',
        'badge_variant',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
            'badge_variant' => 'integer',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }
}
