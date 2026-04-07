<?php

namespace App\Models\PaymentTermItem;

use Illuminate\Database\Eloquent\Model;

class PaymentTermItem extends Model
{
    protected $table = 'payment_term_items';

    protected $fillable = [
        'title',
        'description',
        'icon',
        'icon_color',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
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
