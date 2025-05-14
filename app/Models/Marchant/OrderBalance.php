<?php

namespace App\Models\Marchant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderBalance extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $table = 'orders';

    protected $fillable = [
        'id',
        'ordered_by',
        'payment_gateway_id',
        'amount',
        'diamond_quantity',
        'status',
        'transaction_id',
        'attachment_url',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];
}
