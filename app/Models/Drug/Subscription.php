<?php

namespace App\Models\Drug;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $primaryKey = 'subscription_id';

    protected $table = 'subscriptions';

    protected $fillable = [
        'subscription_id',
        'subscription_name',
        'subscription_type_id',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];
}
