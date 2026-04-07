<?php

namespace App\Models\PaymentInstructionHero;

use Illuminate\Database\Eloquent\Model;

class PaymentInstructionHero extends Model
{
    protected $fillable = [
        'title',
        'description',
        'banner_image',
        'status',
    ];
}
