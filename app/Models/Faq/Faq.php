<?php

namespace App\Models\Faq;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $primaryKey = 'faq_id';
    protected $table = 'faqs';

    protected $fillable = [
        'faq_id',
        'question',
        'answer',
        'order',
        'status',
    ];
}

