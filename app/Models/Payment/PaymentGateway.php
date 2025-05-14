<?php

namespace App\Models\Payment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $table = 'payment_gateways';

    protected $fillable = [
        'id',
        'gateway_name',
        'details',
        'currency_code',
        'rate',
        'active',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];
}
