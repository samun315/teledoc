<?php

namespace App\Models\PaymentInstructionPage;

use Illuminate\Database\Eloquent\Model;

class PaymentInstructionPageSection extends Model
{
    protected $table = 'payment_instruction_page_sections';

    protected $fillable = [
        'section',
        'content',
    ];
}
