<?php

namespace App\Models\Drug;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionType extends Model
{
    use HasFactory;

    protected $primaryKey = 'subscription_type_id';

    protected $table = 'subscription_types';

    protected $fillable = [
        'subscription_type_id',
        'subscription_type',
        'status',
        'orders',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];
}
