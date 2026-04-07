<?php

namespace App\Models\PaymentMode;

use Illuminate\Database\Eloquent\Model;

class PaymentMode extends Model
{
    protected $fillable = [
        'title',
        'image',
        'account_details',
        'instruction',
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
